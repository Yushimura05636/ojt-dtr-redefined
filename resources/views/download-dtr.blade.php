<form id="downloadForm" action="{{ route('download.pdf') }}" method="POST">
    @csrf
    <input type="hidden" name="user" value="{{ json_encode($user, true) }}">
    <input type="hidden" name="yearlyTotals" value="{{ json_encode($yearlyTotals, true) }}">
    <input type="hidden" name="records" value="{{ json_encode($records, true) }}">
    <input type="hidden" name="totalHoursPerMonth" value="{{ json_encode($totalHoursPerMonth, true) }}">
    <input type="hidden" name="selectedMonth" value="{{ $selectedMonth }}">
    <input type="hidden" name="selectedYear" value="{{ $selectedYear }}">
    <input type="hidden" name="pagination" value="{{ json_encode($pagination, true) }}">
    <input type="hidden" name="type" value="{{ json_encode($type) }}">
    <input type="hidden" name="approved_by" value="{{$approved_by}}">
</form>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("downloadForm").submit();
    });
</script>