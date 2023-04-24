function newQuiz() {
    document.getElementById('backdrop').style.left = "0%";
    document.getElementById('quizForm').style.left = "50%";
}

function closeSetup() {
    document.getElementById('backdrop').style.left = "-150%";
    document.getElementById('quizForm').style.left = "250%";
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

// Countdown Timer
function countdown(minutes) {
    var seconds = minutes * 60;
    if(localStorage.getItem("timeLeft") > 0){
        seconds = localStorage.getItem("timeLeft");
    }
    var timer = setInterval(function() {
      var minutesLeft = Math.floor(seconds / 60);
      var secondsLeft = seconds % 60;
      var secondsUse = (minutes * 60) - seconds;
      var minutesUsed = Math.floor(secondsUse / 60);
      var secondsUsed = secondsUse % 60;
      localStorage.setItem('timeLeft', seconds);
      secondsLeft = secondsLeft < 10 ? "0" + secondsLeft : secondsLeft;
      $(".timer .time").html("Time Left: " + minutesLeft + ":" + secondsLeft);
      $("#timeFinished").val(minutesUsed + ':' + secondsUsed);
      if (seconds == 0) {
        clearInterval(timer);
        $(".timer .time").html("Time's up!");
        $("#submitQuiz").trigger("click");
        localStorage.setItem('timeLeft', seconds);
      }
      seconds--;
    }, 1000);
  }

  var link = window.location.href;

//   if(link.includes("takeQuiz")){
//     countdown(10);
//   }


  var questionLength = $(".question").length

// Pagination
function prevQuestion(e){
    var current = $(".question.show");
    var currentIn = current.index() - 1;
    var prev = current.prev(".question")
    var nextIn = $(".question.show").index();
    if(prev.length > 0){
        current.removeClass("show")
        prev.addClass("show")
    }    
    answered();
    $(".quest-numbs .question-tag").removeClass("active");
    $(".quest-numbs .question-tag").eq(currentIn).addClass("active");
    if(nextIn >= questionLength){
        $(".nextBu").hide();
    }else{
        $(".nextBu").show();
    }
    if($(".question.show").index() <= 0){
        $(".prevBu").hide();
    }else{
        $(".prevBu").show();
    }
}

if($(".question.show").index() <= 0){
    $(".prevBu").hide();
}else{
    $(".prevBu").show();
}
$(".quest-numbs .question-tag").eq($(".question.show").index()).addClass("active");

function nextQuestion(){
    var current = $(".question.show");
    var currentIn = current.index() + 1;
    var next = current.next(".question")
    if(next.length > 0){
        current.removeClass("show")
        next.addClass("show")
    }
    $(".quest-numbs .question-tag").removeClass("active");
    $(".quest-numbs .question-tag").eq(currentIn).addClass("active");
    var nextIn = $(".question.show").index() + 1;
    answered();

    if(nextIn >= questionLength){
        $(".nextBu").hide();
    }else{
        $(".nextBu").show();
    }
    if($(".question.show").index() <= 0){
        $(".prevBu").hide();
    }else{
        $(".prevBu").show();
    }
}

$(".quest-numbs .question-tag").on("click", function(e){
    e.preventDefault();
    $(".quest-numbs .question-tag").removeClass("active")
    $(this).addClass("active")
    var tagIn = $(this).index();
    $(".question").removeClass("show");
    $(".question").eq(tagIn).addClass("show");
    var current = $(".question.show");
    var nextIn = $(".question.show").index() + 1;

    if(nextIn >= questionLength){
        $(".nextBu").hide();
    }else{
        $(".nextBu").show();
    }
    if($(".question.show").index() <= 0){
        $(".prevBu").hide();
    }else{
        $(".prevBu").show();
    }
})

$(".question .quiz-ops input").on("click", function(){
    answered();
})


function answered(){
    $(".question .quiz-ops input:checked").each(function(){
        var checked = $(this).parents(".question").index();
        $(".quest-numbs .question-tag").eq(checked).addClass("answered");
    })
}


// Add event listeners to all checkboxes in all forms
var forms = $(".question");
for (var i = 0; i < forms.length; i++) {
  var form = forms[i];
  form.addEventListener('change', function(e) {
    var formId = e.target.form.id;
    var checkboxName = e.target.id;
    var isChecked = e.target.checked;
    // Get current progress from localStorage
    var progress = JSON.parse(localStorage.getItem("formProgress")) || {};
    // Update progress with the new checkbox value
    progress[checkboxName] = isChecked;
    // Save updated progress to localStorage
    localStorage.setItem("formProgress", JSON.stringify(progress));
  });
}

// Set the checkbox values based on the progress stored in localStorage
for (var i = 0; i < forms.length; i++) {
  var form = forms[i];
  var progress = JSON.parse(localStorage.getItem(form.id)) || {};
  var checkboxes = form.getElementsByTagName('input');
  for (var j = 0; j < checkboxes.length; j++) {
    var checkbox = checkboxes[j];
    var checkboxName = checkbox.id;
    if (progress.hasOwnProperty(checkboxName)) {
      checkbox.checked = progress[checkboxName];
    }
  }
}

var progress = JSON.parse(localStorage.getItem("formProgress"));
$.each((progress), function(v, i){
    $('#'+v).attr("checked", true);
})


answered();

if($(".quest-numbs .question-tag.answered").length > 0){
    var qL = $(".quest-numbs .question-tag").length;
    var qI = $(".quest-numbs .question-tag.answererd").last().index();
    var qpl = qI + 1;
    if(qpl < qL || qI == qL){
        $(".quest-numbs .question-tag").removeClass("active");
        $(".quest-numbs .question-tag").eq(qI).addClass("active")
        $(".question").removeClass("show");
        $(".question").eq(qI).addClass("show")
    }
}

$("#submitQuiz").on("click", function(e){
    e.preventDefault();
    var form = $("#quizFormer");
    var data = form.serialize();
    // console.log(data)
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
            }else if(response.score){
                form.prepend('<div class="success messageBox">Your Score Is: '+response.score+'<div class="close">x</div></div>');
                localStorage.removeItem("timeLeft");
                localStorage.removeItem("formProgress");
                setTimeout(function(){
                    window.location.href = "resultview.php?quiz_id=" + $("#quizId").val();
                }, 1000)
            }
        }
    })
})

$(".joinForm").on("submit", function(e){
    e.preventDefault();
    var form = $(this);
    var data = form.serialize();
    // console.log(data)
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
                // $.each(JSON.parse(errors), function(v, i){
                    form.prepend('<div class="error messageBox"> '+errors+' <div class="close">x</div></div>')
                // })
            }else if(response.success){
                form.prepend('<div class="success messageBox">'+response.success+'<div class="close">x</div></div>');
                setTimeout(function(){
                    window.location.href = "quizzes.php";
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