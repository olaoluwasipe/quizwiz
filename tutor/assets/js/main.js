function newQuiz() {
    document.getElementById('backdrop').style.left = "0%";
    document.getElementById('quizForm').style.left = "50%";
}

function closeSetup() {
    document.getElementById('backdrop').style.left = "-150%";
    document.getElementById('quizForm').style.left = "250%";
    document.getElementById('updateForm').style.left = "250%";
}

function closeSide() {
    document.getElementById('opener').style.display = "block";
    document.getElementById('closer').style.display = "none";
    document.getElementById('sidenav').style.width = "0";
    document.getElementById('truePage').style.paddingLeft = "20px";
}

function openSide() {
    document.getElementById('closer').style.display = "block";
    document.getElementById('opener').style.display = "none";
    document.getElementById('sidenav').style.width = "180px";
    document.getElementById('truePage').style.paddingLeft = "200px";
}

function newBank() {
    document.getElementById('backdrop').style.left = "0%";
    document.getElementById('bankForm').style.left = "50%";
}

function closeSetup2() {
    document.getElementById('backdrop').style.left = "-150%";
    document.getElementById('bankForm').style.left = "250%";
}

function newQuestion() {
    document.getElementById('backdrop').style.left = "0%";
    document.getElementById('quizQuestionForm').style.left = "50%";
}

function editQuestion(qid, question, options, answer) {
    document.getElementById('backdrop').style.left = "0%";
    document.getElementById('updatequizQuestionForm').style.left = "50%";
    var sel;
    $("#updatequizQuestionForm .optionsTable").html("");
    $("#updatequizQuestionForm .quest_id").val(qid);
    $("#updatequizQuestionForm .questionFIll").val(question);
    $.each((options), function(v,i){
        if(i == answer){
            sel = "checked";
        }else{
            sel = "";
        }
        $("#updatequizQuestionForm .optionsTable").append(`
        <tr>
            <td>
                <input type="text" name="option[]" value="`+i+`" id="option1">
            </td>
            <td>
                <input type="radio" name="answer" `+sel+` value="`+i+`" required id="answer1">
                <div class="closeBtn">
                    <i class="fas fa-times"></i>
                </div>
            </td>
        </tr>
        `)
    })
}

function editQuiz(qid, title, desc, duration, noOfQuestions, scorePerQuestions, dateScheduled, dateEnd, questionBank, isRandom, showAnswers) {
    document.getElementById('backdrop').style.left = "0%";
    document.getElementById('updateForm').style.left = "50%";
    var sel;
    $("#updateForm #quizTitle").val(title);
    $("#updateForm #quizDesc").val(desc);
    $("#updateForm #quizDuration option").each(function(i){
        if($(this).attr("value") == duration){
            $(this).attr("selected", true)
        }
    })
    $("#updateForm #quizQuestions option").each(function(i){
        if($(this).attr("value") == noOfQuestions){
            $(this).attr("selected", true)
        }
    })
    $("#updateForm #quizScore option").each(function(i){
        if($(this).attr("value") == scorePerQuestions){
            $(this).attr("selected", true)
        }
    })
    $("#updateForm #startDate").val(dateScheduled);
    $("#updateForm #endDate").val(dateEnd);
    $("#updateForm #quizBank option").each(function(i){
        if($(this).attr("value") == questionBank){
            $(this).attr("selected", true)
        }
    })
    $("#updateForm #reveal option").each(function(i){
        if($(this).attr("value") == showAnswers){
            $(this).attr("selected", true)
        }
    })
    $("#updateForm #random option").each(function(i){
        if($(this).attr("value") == isRandom){
            $(this).attr("selected", true)
        }
    })
    $("#updateForm #updateQuiz").val(qid);
}

function closeQueSetup() {
    document.getElementById('backdrop').style.left = "-150%";
    document.getElementById('quizQuestionForm').style.left = "250%";
    document.getElementById('updatequizQuestionForm').style.left = "250%";
}


// Form submits

$(".modalFormer").on("submit", function(e){
    e.preventDefault();
    var form = $(this);
    var data = form.serialize();
    $.ajax({
        url: '../functions/questions.php',
        dataType: 'json',
        data: data,
        processData: 'false',
        type: 'POST',
        success: function(response){
            console.log(response)
            if(response.errors){
                var errors = response.errors;
                $.each((errors), function(v, i){
                    form.prepend('<div class="error messageBox"> '+i+' <div class="close">x</div></div>')
                })
            }else if(response.success){
                form.prepend('<div class="success messageBox"> '+response.success+'<div class="close">x</div></div>');
                setTimeout(function(){
                    window.location.reload();
                }, 1000)
            }
        }
    })
})


$(document).on("click", ".messageBox .close", function(e){
    e.preventDefault();
    $(this).parent().remove()
})

$(".changeForm").on("submit", function(e){
    e.preventDefault();
    var form = $(this);
    var data = form.serialize();
    // console.log(data)
    $.ajax({
        url: '../functions/auth.php',
        dataType: 'json',
        data: data,
        processData: 'false',
        type: 'POST',
        success: function(response){
            console.log(response)
            if(response.errors){
                var errors = response.errors;
                $.each((errors), function(v, i){
                    form.prepend('<div class="error messageBox"> '+i+' <div class="close">x</div></div>')
                })
            }
            if(response.error){
                var error = response.error;
                form.prepend('<div class="error messageBox"> '+error+' <div class="close">x</div></div>')
            }
            if(response.success){
                form.prepend('<div class="success messageBox">'+response.success+'<div class="close">x</div></div>');
                setTimeout(function(){
                    window.location.href = "quizzes.php";
                }, 1000)
            }
        }
    })
})

function deleteBank(id){
    var item = $(this).parent("tr");
    $.ajax({
        url: '../functions/questions.php',
        dataType: 'json',
        data: {deleteBank: id},
        processData: 'false',
        type: 'POST',
        success: function(response){
            console.log(response)
            item.remove();
            window.location.href = "questionbank.php"
        }
    })
}

function deleteQuestion(id){
    var item = $(this).parents(".question");
    $.ajax({
        url: '../functions/questions.php',
        dataType: 'json',
        data: {deleteQuestion: id},
        processData: 'false',
        type: 'POST',
        success: function(response){
            console.log(response)
            item.remove();
            window.location.reload();
        }
    })
}



// Profile Image Upload Handler

$(".editProfile").on("click", function(e){
    e.preventDefault();

    $(".profile.extended .user-info div").each(function(i){
        $(this).find(".curr").last().toggleClass("hide")
        $(this).find(".curr").first().toggleClass("hide")
    })

    $(".saveProfile").toggleClass("hide")
    $(".profile.extended .user-image").toggleClass("edit")
})

$(document).on("click", ".profile.extended .user-image.edit", function(){
    $("#user-image").click();
})

$("#user-image").on("change", function(){
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
     {
        var reader = new FileReader();

        reader.onload = function (e) {
           $('.profile.extended .user-image img').attr('src', e.target.result);
        }
       reader.readAsDataURL(input.files[0]);
    }
    else
    {
      $('.profile.extended .user-image img').attr('src', '../assets/img/default.webm');
    }
})

// Students Pagination
$(".students .opts .opt").on("click", function(e){
    e.preventDefault();
    $(".students .opts .opt").removeClass("active")
    $(this).addClass("active")
    var tagIn = $(this).index();
    $(".students .list").removeClass("active");
    $(".students .list").eq(tagIn).addClass("active");
})