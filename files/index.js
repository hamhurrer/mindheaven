var oinputs = document.getElementsByTagName("input");
window.csrfToken = document.getElementById('csrf-token').value;
let text = document.getElementById('text');
let hill1 = document.getElementById('hill1');
let hill4 = document.getElementById('hill4');
let hill5 = document.getElementById('hill5');
let star = document.getElementById('star');
let logout = document.getElementById('logout-btn');
window.addEventListener('scroll', () => {
    let value = window.scrollY;
    text.style.wordSpacing = '0rem';
    text.style.marginTop = value *0.5 + 'px';
    star.style.top = value * 0.5 + 'px';
    hill1.style.top = value * -0.1 + 'px';
    hill5.style.left = value * 1.2 + 'px';
    hill4.style.left = value * -1.2 + 'px';
    hill1.style.opacity = 100-value*0.1 +'%';
});

let slides = document.querySelectorAll('.law .slides-container .slide');
let index = 0;

function next(){
    slides[index].classList.remove('active');
    index = (index + 1) % (slides.length);
    slides[index].classList.add('active');
}

function prev(){
    slides[index].classList.remove('active');
    index = (index - 1 + (slides.length)) % (slides.length);
    slides[index].classList.add('active');
}

window.onscroll = () => {
            loginForm.classList.remove('active');
        }

        let loginForm = document.querySelector('.login-form');
        let createForm = document.querySelector('.create-form');
        let nameDisplay = document.querySelector('#name');
        let registeredUsers = {};

        document.querySelector('#login-btn').onclick = () => {
            if (loginForm.classList.contains('active')) {
                text.style.wordSpacing = '0rem';
                loginForm.classList.remove('active');
            }else if(createForm.classList.contains('active')){
                createForm.classList.remove('active');
                text.style.wordSpacing = '0rem';
            }else {
                loginForm.classList.add('active');
                text.style.wordSpacing = '48rem';
                document.getElementById("alert0").style.display = "none";
            }
        }
        document.querySelector('#submit-btn').onclick = (event) => {
            let ale=document.getElementById("alert0");
            var time = new Date();
            if ((!oinputs[0].value || !oinputs[1].value)) {
                alert("输入内容不能为空");
            } else {     
                $ajax({
                    method : "post",
                    url : "./files/login.php", 
                    data : {
                        username : oinputs[0].value,
                        password : oinputs[1].value                        
                    },
                    success : function(result){
                        var res = JSON.parse(result);
                        if(res.code == 2){      
                            window.csrfToken = res.csrf_token;                      
                            loginForm.classList.remove('active');
                            text.style.wordSpacing = '0rem';
                            ale.className = "alert-success";
                            ale.innerHTML = res.message;
                            window.location.href = 'index.php';
                            alert("登录成功");
                            ale.style.display = "block";
                        }else{
                            ale.className = "alert-warning";
                            ale.innerHTML = res.message;
                            ale.style.display = "block";
                        }
                    },
                    error : function(msg){
                        console.log(msg);
                    }
                });
            }
        }
        if (logout) {
            logout.addEventListener('click', function() {
            let ale=document.getElementById("alert1");
            $ajax({
                method : "post",
                url : "./files/logout.php", 
                data:{},
                success : function(result){
                    var res = JSON.parse(result);
                    if(res.code == 2){     
                        window.location.href = 'index.php';                       
                        alert("已退出登录");
                    }else{
                        ale.className = "alert-warning";
                        ale.innerHTML = res.message;
                        ale.style.display = "block";
                    }
                },
                error : function(msg){
                    console.log(msg);
                }
            });

        }   ) }

        
        document.querySelector('#create-btn').onclick = () => {
            loginForm.classList.remove('active');
            createForm.classList.add('active');
        }

        document.querySelector('#register-btn').onclick = () => {
            var time = new Date();
            var ale = document.getElementById("alert");
            if ((!oinputs[5].value || !oinputs[6].value)) {
                alert("输入内容不能为空");
            } else {
                $ajax({
                    method : "post",
                    url : "./files/register.php",
                    data : {
                        username : oinputs[5].value,
                        password : oinputs[6].value,
                        create_time : time.getTime()//获取到毫秒数
                    },
                    success : function(result){
                        var res = JSON.parse(result);
                        if(res.code == 3){
                            createForm.classList.remove('active');
                            loginForm.classList.add('active');
                            ale.className = "alert-success";
                            ale.innerHTML = res.message;
                            ale.style.display = "block";
                        }else{
                            ale.className = "alert-warning";
                            ale.innerHTML = res.message;
                            var oinputs = document.getElementsByTagName("input");ale.style.display = "block";
                        }
                    },
                    error : function(msg){
                        console.log(msg);
                    }
                });
            }
        }
        function addCommentToPage(commentText, commentList) {
            const commentItem = document.createElement('div');
            commentItem.classList.add('comment-item', 'fade-in');

            const commentTextElement = document.createElement('p');
            commentTextElement.textContent = commentText;

            const deleteButton = document.createElement('button');
            deleteButton.classList.add('delete-button');
            deleteButton.innerHTML = '<i class="fa-solid fa-trash"></i> 删除';
            deleteButton.addEventListener('click', () => {
                commentItem.classList.add('fade-out');
                setTimeout(() => {
                    commentList.removeChild(commentItem);
                    removeCommentFromLocalStorage(commentText, getListIndex(commentList));
                }, 300);
            });

            commentItem.appendChild(commentTextElement);
            commentItem.appendChild(deleteButton);
            commentList.appendChild(commentItem);
        }

        function saveCommentToLocalStorage(commentText, postIndex) {
            const storedComments = JSON.parse(localStorage.getItem(`comments-${postIndex}`)) || [];
            storedComments.push(commentText);
            localStorage.setItem(`comments-${postIndex}`, JSON.stringify(storedComments));
        }

        function removeCommentFromLocalStorage(commentText, postIndex) {
            const storedComments = JSON.parse(localStorage.getItem(`comments-${postIndex}`)) || [];
            const newComments = storedComments.filter(comment => comment!== commentText);
            localStorage.setItem(`comments-${postIndex}`, JSON.stringify(newComments));
        }

        function getListIndex(commentList) {
            return parseInt(commentList.id.split('-')[2]);
        }

        function toggleCommentSection(postIndex) {
            const commentSection = document.getElementById(`comment-section-${postIndex}`);
            if (commentSection.style.display === 'none') {
                commentSection.style.display = 'block';
            } else {
                commentSection.style.display = 'none';
            }
        }

        for (let i = 1; i <= 3; i++) {
            const commentInput = document.getElementById(`comment-input-${i}`);
            const addCommentButton = document.getElementById(`add-comment-${i}`);
            const commentList = document.getElementById(`comment-list-${i}`);

            // 从本地存储中加载评论
            const storedComments = JSON.parse(localStorage.getItem(`comments-${i}`)) || [];
            storedComments.forEach(comment => {
                addCommentToPage(comment, commentList);
            });

            addCommentButton.addEventListener('click', () => {
                const commentText = commentInput.value.trim();
                if (commentText) {
                    addCommentToPage(commentText, commentList);
                    saveCommentToLocalStorage(commentText, i);
                    commentInput.value = '';
                }
            });
        }

   