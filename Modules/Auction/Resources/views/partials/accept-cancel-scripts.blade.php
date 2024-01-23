<script>
    $(".cancelBtn").on("click", function() {
        var id = $(this).data('id');
        $('#cancelForm').attr('action', `/dashboard/bid-request/${id}/cancel`);
    });
    $(".acceptBtn").on("click", function() {
        var id = $(this).data('id');
        $('#acceptForm').attr('action', `/dashboard/bid-request/${id}/accept`);
    });
</script>
