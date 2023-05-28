function ajax_search(url) {
    $(document).ready(function() {
        $("#searchInput").on("keyup", function() {
            var searchValue = $(this).val();
            if(searchValue.length >= 2){
            $.ajax({
                url: url,
                dataType: "json",
                success: function(data) {
                    var suggestions = [];
                    $.each(data, function(index, value){
                    if(value.toLowerCase().indexOf(searchValue.toLowerCase()) >= 0){
                        suggestions.push("<option value='" + value + "'>");
                    }
                    });
                    $("#suggestions").html(suggestions.join(""));
                }
            });
            } else {
                $("#suggestions").html("");
            }
        });
    });
};