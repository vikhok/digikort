function ajax_search_companies(url) {
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

function ajax_search_users(url) {
    $(document).ready(function(){
        $("#searchInput").on("keyup", function(){
            var searchValue = $(this).val();
            if(searchValue.length >= 2){
                $.ajax({
                    url: url,
                    dataType: "json",
                    success: function(data){
                        var suggestions = [];
                        $.each(data, function(index, value){
                            if(value.toLowerCase().indexOf(searchValue.toLowerCase()) >= 0){
                                suggestions.push(
                                    //"<div>" + value + "</div>"
                                    "<div class='notat-boks-wrapper'>" +
                                        "<div class='notat-boks'>" +
                                            "<a href='note.php?note_id=<?=$note[`note_id`]?>' style='color:black'>" +
                                                value +
                                            "</a>" +
                                        "</div>" +
                                    "</div>"
                                );
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