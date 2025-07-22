<form action="{{ route('certificate.preview.generate') }}" method="POST">
    @csrf
    <label>Name:</label>
    <input type="text" name="name" required><br><br>

    <label>Roll No:</label>
    <input type="text" name="roll_no" required><br><br>

    <button type="submit">Generate Certificate</button>
</form>
