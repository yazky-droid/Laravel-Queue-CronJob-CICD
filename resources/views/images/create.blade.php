<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Image App</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<div class="max-w-lg mx-auto py-10">
    <form action="/image" method="post" class="flex items-center justify-between border border-gray-300 py-4 px-2" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" id="image">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Upload File</button>
    </form>
</div>
</body>
</html>
