<form method="post" action="/files" enctype="multipart/form-data">
    @csrf
    <input type="text" name="file_name" />
    <input type="file" name="file" />
    <button type="submit">upload</button>
</form>