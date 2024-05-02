
let courseBlock;
document.getElementById("course").addEventListener("change", function () {
    displayNoneCourseBlock();
    var selectedCourseId = this.value;
    if(courseBlock){
        courseBlock.style.display = "none";
    }
    courseBlock = document.getElementById("course_block_" + selectedCourseId);
    courseBlock.style.display = "block";
});
function displayNoneCourseBlock(){
    var courseBlocks = document.querySelector("course_block");
    if(courseBlocks){
        courseBlocks.forEach(function(element) {
            element.style.display = "none";
        });
    }
}
$('#appointment_form').submit(function (event) {
    event.preventDefault();
    var formData = $(this).serialize();
    console.log(formData);
    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formData,
        success: function (response) {
            if(response.success ==='isInBase'){
                $('.alert-danger').css('display', 'block');
                $('.alert-danger').text('Ви вже записані на цей курс!');
            }else {
                $('.alert-success').css('display', 'block');
                $('.alert-success').text('Ви успішно зареєстровані!');
                setTimeout(function () {
                    window.history.back();
                }, 1000);
            }
        },
        error: function (xhr, status, error) {
            $('.alert-danger').css('display', 'block');
            $('.alert-danger').text('Помилка, спробуйте будь ласка знову пізніше!');
        }
    });
})
;