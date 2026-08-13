<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DropdownOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'category', 'label', 'sort_order', 'is_active', 'country', 'website', 'image_path', 'type',
        'margin_top', 'margin_bottom', 'margin_left', 'margin_right'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'margin_top' => 'integer',
        'margin_bottom' => 'integer',
        'margin_left' => 'integer',
        'margin_right' => 'integer',
    ];

    /**
     * Auto detect top (header) and bottom (footer) margins of a pad image using PHP GD.
     */
    public static function autoDetectPadMargins(string $fullImagePath): array
    {
        $defaultMargins = ['margin_top' => 130, 'margin_bottom' => 120, 'margin_left' => 0, 'margin_right' => 0];
        
        if (!file_exists($fullImagePath) || !function_exists('imagecreatefromstring')) {
            return $defaultMargins;
        }

        try {
            $imageData = @file_get_contents($fullImagePath);
            if (!$imageData) return $defaultMargins;

            $img = @imagecreatefromstring($imageData);
            if (!$img) return $defaultMargins;

            $width = imagesx($img);
            $height = imagesy($img);

            $topMargin = 130;
            $bottomMargin = 120;

            // 1. Scan Top Down for Header Height (looking for continuous white/transparent space)
            for ($y = 0; $y < $height; $y++) {
                $isWhiteRow = true;
                for ($x = 0; $x < $width; $x += 15) {
                    $rgb = imagecolorat($img, $x, $y);
                    $r = ($rgb >> 16) & 0xFF;
                    $g = ($rgb >> 8) & 0xFF;
                    $b = $rgb & 0xFF;
                    
                    // Luminance / lightness check (ignore faint watermarks > 240)
                    if ($r < 240 || $g < 240 || $b < 240) {
                        $isWhiteRow = false;
                        break;
                    }
                }
                if ($isWhiteRow && $y > 60) {
                    $topMargin = $y;
                    break;
                }
            }

            // 2. Scan Bottom Up for Footer Height
            for ($y = $height - 1; $y >= 0; $y--) {
                $isWhiteRow = true;
                for ($x = 0; $x < $width; $x += 15) {
                    $rgb = imagecolorat($img, $x, $y);
                    $r = ($rgb >> 16) & 0xFF;
                    $g = ($rgb >> 8) & 0xFF;
                    $b = $rgb & 0xFF;
                    
                    if ($r < 240 || $g < 240 || $b < 240) {
                        $isWhiteRow = false;
                        break;
                    }
                }
                if ($isWhiteRow && ($height - $y) > 40) {
                    $bottomMargin = $height - $y;
                    break;
                }
            }

            imagedestroy($img);

            return [
                'margin_top' => $topMargin > 0 ? $topMargin : 130,
                'margin_bottom' => $bottomMargin > 0 ? $bottomMargin : 120,
                'margin_left' => 0,
                'margin_right' => 0,
            ];
        } catch (\Throwable $e) {
            return $defaultMargins;
        }
    }

    // Available categories with their display names
    public static array $categories = [
        'study_destination' => 'Preferred Study Destination',
        'study_method' => 'Preferred Study Method',
        'level_of_study' => 'Level of Study',
        'highest_qualification' => 'Highest Qualification',
        'financial_source' => 'Funding Source',
        'english_proficiency' => 'English Language Proficiency',
        'department' => 'Departments',
        'document_type' => 'Document Types',
        'letter_type' => 'Template Types',
        'campus_type' => 'Campus Types',
        'currency' => 'Currencies',
        'course_category' => 'Course Categories',
        'subject_area' => 'Subject Areas',
        'intake' => 'Intakes',
        'additional_cost' => 'Additional Cost Types',
        'letter_head' => 'Letter Head Pads (Any Size)',
        'visa_required_countries' => 'Visa Required Countries',
    ];

    /**
     * Get active options for a given category, ordered by sort_order then label.
     * Returns a plain array of label strings for use in views.
     */
    public static function active(string $category): array
    {
        return static::where('category', $category)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('label')
            ->pluck('label')
            ->toArray();
    }

    /**
     * Get fast optimized local image path for PDF generation.
     * Downscales high-resolution pad images (e.g. 5000px) to A4 print resolution (~1240x1754px)
     * so DomPDF renders in 0.3s instead of timing out.
     */
    public static function getOptimizedPadPath(?string $relativeImagePath): ?string
    {
        if (empty($relativeImagePath)) return null;

        $fullPath = storage_path('app/public/' . $relativeImagePath);
        if (!file_exists($fullPath)) return null;

        $info = pathinfo($fullPath);
        $optPath = $info['dirname'] . '/' . $info['filename'] . '_opt.jpg';

        if (file_exists($optPath)) {
            return str_replace('\\', '/', $optPath);
        }

        try {
            list($w, $h) = @getimagesize($fullPath);
            if ($w && $h && ($w > 1500 || $h > 2100)) {
                $targetW = 1240;
                $targetH = (int) round($targetW * ($h / $w));

                $srcImg = @imagecreatefromstring(file_get_contents($fullPath));
                if ($srcImg) {
                    $dstImg = imagecreatetruecolor($targetW, $targetH);
                    $white = imagecolorallocate($dstImg, 255, 255, 255);
                    imagefill($dstImg, 0, 0, $white);
                    imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $targetW, $targetH, $w, $h);
                    imagejpeg($dstImg, $optPath, 92);
                    imagedestroy($srcImg);
                    imagedestroy($dstImg);
                    return str_replace('\\', '/', $optPath);
                }
            }
        } catch (\Throwable $e) {}

        return str_replace('\\', '/', $fullPath);
    }

    /**
     * Get all options for a given category (including inactive).
     */
    public static function forCategory(string $category)
    {
        return static::where('category', $category)
            ->orderBy('sort_order')
            ->orderBy('label')
            ->get();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
