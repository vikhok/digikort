$(document).ready(function(){
    $("#searchInput").on("keyup", function(){
        var searchValue = $(this).val();
        if(searchValue.length >= 1){
            $.ajax({
                url: "all_users.php",
                dataType: "json",
                success: function(data){
                    var suggestions = [];
                    $.each(data, function(index, value){
                        if(value.toLowerCase().indexOf(searchValue.toLowerCase()) >= 0){
                            suggestions.push("<div>" + value + "</div>");
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