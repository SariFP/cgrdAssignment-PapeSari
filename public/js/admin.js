document.addEventListener('DOMContentLoaded', function () {
  // Edit: Form füllen + Titel/Knopf anpassen
  $(document).on('click', '.edit-btn', function () {
    const id = $(this).data('id');
    const title = $(this).data('title');
    const content = $(this).data('content');

    $('#news-id').val(id);
    $('#title').val(title);
    $('#content').val(content);
    $('#action').val('edit');

    $('.form-title').text('Edit News');
    $('#save-btn').text('Save');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
});
