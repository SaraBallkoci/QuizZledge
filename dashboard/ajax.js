/*$(document).ready(function() {

    $('#search-box').keyup(function() {
       
        //get the input from the search-box

        var input = $(this).val();
        //alert(input);

        if(input !=""){
            $.ajax({
                //send ajax request to get data
                url:"search.php",
                method: "POST",
                data:{input:input},

                  success:function(data){
                    $("#search-results").html(data);
                    $("#search-results").css("display","block");//display data if input is not empty

                  }
            });
        }else{
            $("#search-results").css("display","none"); //do not display data if input is empty
        }
    });
});*/

$(document).ready(function() {
    const showMoreButton = $('#show-more-button'); // Get the button element

    $('#search-box').keyup(function() {
        var input = $(this).val().toLowerCase();
        var $pictureContainer = $("#picture-container");
        var $allImages = $pictureContainer.find('.image');
        var $visibleImages = $();

        $allImages.each(function(index) {
            var categoryTitle = $(this).find(".quiz-visible-title").text().toLowerCase();
            
            if(categoryTitle.includes(input)) {
                $visibleImages = $visibleImages.add(this);
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // Show or hide "Show More" button based on search input
        if (input) {
            showMoreButton.hide(); // Hide button when searching
        } else {
            showMoreButton.show(); // Show button when input is empty
            // Apply the "Show More/Less" state
            $allImages.each(function(index) {
                if (index >= 8 && !isShowMoreActive) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        }

        // If the search box is empty, restore the original order
        if (!input) {
            $allImages.sort(function(a, b) {
                return $(a).data('original-index') - $(b).data('original-index');
            }).appendTo($pictureContainer.find('.row').first());
        } else {
            // Append the matched images to the first row
            $pictureContainer.find('.row').first().append($visibleImages);
        }
    });
});




var images1 = ["../images/wooden.jpg", "../images/pic.jpg", "../images/pic2.jpg"];
var index = 0;

document.addEventListener("DOMContentLoaded", function () {
    change();
});

function change() {
    var imgElements = document.querySelectorAll('.slides');

    if (imgElements.length > 0) {
        index++;
        if (index >= images1.length) {
            index = 0;
        }

        imgElements.forEach(function (element) {
            element.src = images1[index];
        });

        setTimeout(change, 30000);
    }
}
