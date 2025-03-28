<!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
<script src="https://cdn.tiny.cloud/1/98si2sbbw55sf2hjy4or3nk8hgy34irdy94ktzhozq568zd7/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea#content', // Replace this CSS selector to match the placeholder element for TinyMCE
        // plugins: 'code table lists',
        // toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'

        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',

    });
</script>
