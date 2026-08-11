<!-- ===============================================-->
<!--    JavaScripts-->
<!-- ===============================================-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('contents/backend/assets')}}/vendors/popper/popper.min.js"></script>
<script src="{{asset('contents/backend/assets')}}/vendors/bootstrap/bootstrap.min.js"></script>
<script src="{{asset('contents/backend/assets')}}/vendors/anchorjs/anchor.min.js"></script>
<script src="{{asset('contents/backend/assets')}}/vendors/is/is.min.js"></script>
<script src="{{asset('contents/backend/assets')}}/vendors/echarts/echarts.min.js"></script>
<script src="{{asset('contents/backend/assets')}}/vendors/fontawesome/all.min.js"></script>
<script src="{{asset('contents/backend/assets')}}/vendors/lodash/lodash.min.js"></script>
<script src="{{asset('contents/backend/assets')}}/vendors/list.js/list.min.js"></script>
<script src="{{asset('contents/backend/assets')}}/assets/js/theme.js"></script>
<script src="{{asset('contents/backend/assets')}}/assets/js/custom.js"></script>
<script src="{{asset('contents/backend/assets')}}/assets/js/fontawesome-iconpicker.min.js"></script>

<!-- Dropzone JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    // Wait for the DOM to load before adding event listeners
    document.addEventListener("DOMContentLoaded", function() {
        // Get all delete buttons
        const deleteButtons = document.querySelectorAll('.dropdown-item.text-danger');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const formId = 'deleteForm' + id;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't to Delete this Record!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form programmatically if confirmed
                        document.getElementById(formId).submit();
                    }
                });
            });
        });
    });
</script>


<script>
  document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.restore-button').forEach(function(button) {
          button.addEventListener('click', function () {
              const id = this.getAttribute('data-id');

              Swal.fire({
                  title: 'Are you sure?',
                  text: "Do you want to restore this record?",
                  icon: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#28a745',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, Restore it!'
              }).then((result) => {
                  if (result.isConfirmed) {
                      document.getElementById('restoreForm' + id).submit();
                  }
              });
          });
      });
  });
</script>

<script>
$(document).ready(function() {
    // Global SweetAlert Delete Confirmation
    $(document).on('click', '.delete-btn-confirm', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        const text = $(this).data('text') || "You won't be able to revert this!";
        
        Swal.fire({
            title: 'Are you sure?',
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>


{{-- <script>
    document.querySelectorAll('.deleteButton').forEach(button => {
    button.addEventListener('click', function() {
        var button = this; // Button clicked
        var id = button.getAttribute('data-id'); // Get the id from data-id attribute

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Disable the button or hide it after clicking
                button.disabled = true; // Disable button
                button.innerHTML = 'Deleting...'; // Optional: Change button text

                // Submit the form programmatically if confirmed
                document.getElementById('deleteForm').submit();
            }
        });
    });
});
</script> --}}



{{--   image preview and deleter or remove item --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
  const imageInput = document.getElementById('imageInput');
  const previewContainer = document.getElementById('previewContainer');

  // Exit early if imageInput or previewContainer does not exist
  if (!imageInput || !previewContainer) return;

  imageInput.addEventListener('change', function () {
      previewContainer.innerHTML = '';

      Array.from(this.files).forEach((file, index) => {
          if (file.type.startsWith('image/')) {
              const reader = new FileReader();

              reader.onload = function (e) {
                  const col = document.createElement('div');
                  col.classList.add('col-md-3', 'position-relative', 'mb-3');

                  col.innerHTML = `
                      <img src="${e.target.result}" class="img-fluid rounded shadow-sm border" style="height: 100px; width:auto; object-fit: cover;">
                      <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 remove-btn" data-index="${index}">X</button>
                  `;

                  previewContainer.appendChild(col);
              };

              reader.readAsDataURL(file);
          }
      });
  });
});

</script>









{{-- bulk selection and delete  --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
      const applyBtn = document.getElementById('bulk-apply-btn');
      const actionSelect = document.getElementById('bulk-action-select');
      
      applyBtn.addEventListener('click', function () {
        const selectedAction = actionSelect.value;
        const selectedCheckboxes = document.querySelectorAll('input[data-bulk-select-row]:checked');
        let selectedIDs = [];
  
        selectedCheckboxes.forEach(cb => selectedIDs.push(cb.value));
  
        if (!selectedAction || selectedIDs.length === 0) {
          Swal.fire('Warning', 'Please select at least one item and an action.', 'warning');
          return;
        }
  
        if (selectedAction === 'delete') {
          Swal.fire({
            title: 'Are you sure?',
            text: `You are about to DELETE ${selectedIDs.length} items!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete!',
            confirmButtonColor: '#d33'
          }).then((result) => {
            if (result.isConfirmed) {
              sendBulkRequest(selectedIDs, 'delete');
            }
          });


        } else if (selectedAction === 'active') {
          Swal.fire({
            title: 'Are you sure?',
            text: `You are about to Active ${selectedIDs.length} items!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Active!',
            confirmButtonColor: '#41AB6D'
          }).then((result) => {
            if (result.isConfirmed) {
              sendBulkRequest(selectedIDs, 'active');
            }
          });
          
        } else if (selectedAction === 'deactive') {
          Swal.fire({
            title: 'Are you sure?',
            text: `You are about to Deactive ${selectedIDs.length} items!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Active!',
            confirmButtonColor: '#d33'
          }).then((result) => {
            if (result.isConfirmed) {
              sendBulkRequest(selectedIDs, 'deactive');
            }
          });
        }else if(selectedAction === 'restore'){
          Swal.fire({
            title: 'Are you sure?',
            text: `You are about to Restore ${selectedIDs.length} items!`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Restore!',
            confirmButtonColor: '#151FE6'
          }).then((result) => {
            if (result.isConfirmed) {
              sendBulkRequest(selectedIDs, 'restore');
            }
          });
        }else if(selectedAction === 'heard_delete'){
          Swal.fire({
            title: 'Are you sure?',
            text: `You are about to DELETE ${selectedIDs.length} items!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete!',
            confirmButtonColor: '#d33'
          }).then((result) => {
            if (result.isConfirmed) {
              sendBulkRequest(selectedIDs, 'heard_delete');
            }
          });
        }

      });

  
      function sendBulkRequest(ids, actionType) {
          fetch(bulkActionUrl, {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({ ids: ids, action: actionType })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              Swal.fire('Done!', data.message, 'success').then(() => location.reload());
            } else {
              Swal.fire('Error', data.message || 'Something went wrong!', 'error');
            }
          });
        }






    });

    // Global Status Toggle Switch Handler
    $(document).on('change', '.global-status-toggle', function() {
        const switchEl = $(this);
        const url = switchEl.data('url');
        const isChecked = switchEl.is(':checked');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'PATCH'
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (typeof toastr !== 'undefined') {
                    toastr.success('Status updated successfully');
                } else if (typeof Swal !== 'undefined') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Status updated successfully'
                    });
                }
            },
            error: function(xhr) {
                switchEl.prop('checked', !isChecked);
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update status. Please try again.'
                    });
                } else {
                    alert('Failed to update status.');
                }
            }
        });
    });
  </script>
  