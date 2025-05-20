<?php
session_start();

// 生成CSRF令牌（如果不存在）
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 检查用户是否已登录
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mindheaven</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="./files/index.css">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
	
	<style>
       .post-container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin: 3rem;
            transition: transform 0.2s ease-in-out;
            border-top:20px;
            space-between: 1rem;
        }

       .post-container:hover {
            transform: translateY(-5px);
        }


       .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 0.5rem;
        }


       .user-id {
            font-size: 0.875rem;
            color: #7f8c8d;
            text-align: center;
        }

       .post-content {
            color: #34495e;
            line-height: 1.6;
            margin-bottom: 1rem;
            padding: 1rem;
        }


       .comment-input {
            border: 1px solid #bdc3c7;
            border-radius: 8px;
            padding: 0.75rem;
            width: 100%;
            margin-bottom: 1rem;
            transition: border-color 0.2s ease-in-out;
        }

       .comment-input:focus {
            outline: none;
            border-color: #3498db;
        }


       .comment-button {
            background-color: #3498db;
            color: #ffffff;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: background-color 0.2s ease-in-out;
        }

       .comment-button:hover {
            background-color: #2980b9;
        }

       .comment-list {
            margin-top: 1.5rem;
        }

       .comment-item {
            background-color: #ecf0f1;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

       .delete-button {
            background-color: #e74c3c;
            color: #ffffff;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            transition: background-color 0.2s ease-in-out;
        }

       .delete-button:hover {
            background-color: #c0392b;
        }


       .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

       .fade-out {
            animation: fadeOut 0.3s ease-in-out;
            opacity: 0;
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }

        /* 评论区域初始隐藏 */
       .comment-section {
            display: none;
        }
		
		.comment-container {
            width: 100%;
            max-width: 900px;
            margin: 10px auto;
            background-color: #e0e0e0;
            padding: 20px;
            box-sizing: border-box;
            display: block;
            border-radius: 10px;
        }    
		
		.comment-container-title{
            text-align: center;
            font-size: xx-large;
            color:#0F4F82 ;     
            letter-spacing: 5rem;
            font-weight: 900;
		}
    </style>
</head>
<body>
    
<!-- header section starts  -->

<header class="header">
    <div class="nav">
        <div class="nav-wrapper">
            <div class="nav-logo">
                <img src="files/image/logo.jpg" alt="Logo">
            </div>
            <div class="nav-item">
                <a href="#" class="alink">
                    <span>🪵树洞</span>
                    <img src="./files/asset/drop.png" alt="">
                </a>
                <div class="nav-drop-down-wrapper">
                    <div class="nav-drop-down">
                        <div class="down-item">
                            <div class="down-item-wrapper">
                                <a href="./files/mood.html">📒情绪日记</a>
                            </div>
                        </div>
                        <div class="down-item">
                            <div class="down-item-wrapper">
                                <a href="./files/PBZS.html">🫂陪伴助手</a>
                            </div>
                        </div>
                        <div class="down-item">
                            <div class="down-item-wrapper">
                                <a href="./files/DAZS.html">📖答案之书</a>
                            </div>
                      </div>                
                    </div>
                </div>
            </div>
            <div class="nav-item">
                <a href="#" class="alink">
                    <span>🔅放松</span>
                    <img src="./files/asset/drop.png" alt="">
                </a>
               <div class="nav-drop-down-wrapper">
                    <div class="nav-drop-down">
                        <div class="down-item">
                            <div class="down-item-wrapper">
                                <a href="./files/music.html">🧘🏻‍♀️冥想</a>
                            </div>
                        </div>            
                        <div class="down-item">
                            <div class="down-item-wrapper">
                                <a href="./files/DY.html">👩🏻‍💻电影</a>
                            </div>
                        </div>                                
                        <div class="down-item">
                            <div class="down-item-wrapper">
                                <a href="./files/youxi.html">🤖小游戏</a>
                            </div>
                        </div>  
                    </div>
                </div>                
            </div>
            <div class="nav-item">
                <a href="#" class="alink">
                    <span>💖爱好</span>
                    <img src="./files/asset/drop.png" alt="">
                </a>
                <div class="nav-drop-down-wrapper">
                    <div class="nav-drop-down">
                        <div class="down-item">
                            <div class="down-item-wrapper">
                                <a href="./files/sport.html">🏃‍运动</a>
                            </div>
                        </div>
                        <div class="down-item">
                            <div class="down-item-wrapper">
                                <a href="./files/cook.html">🍳烹饪</a>
                            </div>
                        </div>
                        <div class="down-item">
                            <div class="down-item-wrapper">
                                <a href="./files/art.html" >🎨艺术</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-item">
                <a href="#" class="alink">
                    <span>💁帮助</span>
                    <img src="./files/asset/drop.png" alt="">
                </a>
                <div class="nav-drop-down-wrapper">
                    <div class="nav-drop-down">
                        <div class="down-item">
                            <div class="down-item-wrapper">
                                <a href="./files/knowle.html" >📕知识科普</a>
                            </div>
                        </div>
                        <div class="down-item">
                            <div class="down-item-wrapper">
                                <a href="./files/psych.html" >⛓️心理咨询</a>
                            </div>
                        </div>
                        <div class="down-item">
                            <div class="down-item-wrapper">
                                <a href="./files/law.html" >⚖法律援助</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-item">
                <div class="icons">
                    <div id="login-btn" class="fas fa-user"></div>
                </div>
            </div>
            <?php if ($isLoggedIn): ?>
            <div class="nav-item">
                <div action="" >
                    <h1 id="name" >欢迎回来，<?= $_SESSION['username']?></h1>
                </div>
            </div>
            <div class="nav-item">
                <div>
                    <div id="alert1">测试文字</div>
                    <h1 id="logout-btn">退出登录</h1>
                </div>
            </div>
            <?php endif; ?>
        </div>


    </div>
	  <div class="login-form">
        <h3 class="text-xl font-bold mb-4">登录</h3>
        <input type="text" placeholder="输入用户名" class="box">
        <input type="password" placeholder="输入密码" class="box">
        <div class="remember flex items-center mb-4">
            <input type="checkbox" name="" id="remember-me">
            <label for="remember-me" class="ml-2">记住我</label>
        </div>
        <div id="alert0">测试文字</div>
        <input type="submit" value="立即登录" class="btn" id="submit-btn">
        <input type="hidden" id="csrf-token" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <p class="mt-2">没有账号? <a href="#" id="create-btn" class="text-blue-500 hover:underline">注册</a></p>
    </div>

    <div class="create-form">
        <h3 class="text-xl font-bold mb-4">注册</h3>
        <input type="text" placeholder="输入用户名" class="box">
        <input type="password" placeholder="输入密码" class="box">
        <div id="alert">测试文字</div>
        <input type="submit" value="立即注册" class="btn" id="register-btn">
    </div>
	

</header>
        <section class="parallax">
            <img src="./files/image/hill11.jpg" id="hill1" alt="">
            <img src="./files/image/star.png" id="star" alt="">
            <img src="./files/image/hill4.png" id="hill4" alt="">
            <img src="./files/image/hill5.png" id="hill5" alt="">       
            <h2 id="text" >MindHeaven Website</h2>
    	</section>

        <!-- Card section from card.html -->
        <section class="merged-container">
            <div class="merged-card">
                <div class="merged-content">
                    <h2>🪵</h2>
                    <h3>🪵树洞</h3>
                    <p>情绪日记支持多形式记录与分类管理;语音AI陪伴具备自然语言理解与情感回应能力;答案之书提供丰富心灵指引</p>
                    <a href="./files/mood.html">MORE</a>
                </div>
            </div>
            <div class="merged-card">
                <div class="merged-content">
                    <h2>🔅</h2>
                    <h3>🔅放松</h3>
                    <p>冥想模块提供多样主题音频指导;冥想电影模块提供影视推荐 资源丰富;小游戏稳定嵌入且种类多样</p>
                    <a href="./files/music.html">MORE</a>
                </div>
            </div>
            <div class="merged-card">
                <div class="merged-content">
                    <h2>💖</h2>
                    <h3>💖爱好</h3>
                    <p>运动、艺术、烹饪板块分别提供详细教程;为爱好培养提供专业化、多样化的教程;让爱好成为你的专属避风港</p>
                    <a href="./files/sport.html">MORE</a>
                </div>
            </div>
            <div class="merged-card">
                <div class="merged-content">
                    <h2>💁</h2>
                    <h3>💁帮助</h3>
                    <p>知识科普以多元形式呈现专业知识;心理咨询实现问卷调研、线上预约及专业指导;法律援助引入AI提供法律知识查询与咨询服务</p>
                    <a href="./files/knowle.html" >MORE</a>
                </div>
            </div>
            <div >
                <section  class="comment-container">
                    <h1 class="comment-container-title">发帖区</h1>
                    
                        <!-- 帖子 1 -->
                        <div class="post-container">
                            <div class="flex space-x-4">
                                <div>
                                    <img src="./files/image/tx1.jpg" alt="User Avatar" class="user-avatar">
                                    <p class="user-id">喵小团</p>
                                </div>
                                <div class="flex-1">
                                    <p class="post-content">原来真的会有人说不爱就不爱了，昨天还在规划未来的人，今天就成了陌生人。在一起的那些日子，一起看过的电影、走过的街道、说过的情话，都像刀子一样扎在心里。我想不通，明明那么相爱的两个人，怎么就走到了这一步？无数个夜晚，我翻来覆去睡不着，满脑子都是我们的回忆。我试图去挽回，却发现一切都是徒劳。现在的我，像个被抽走灵魂的躯壳，做什么都提不起劲。朋友说时间会治愈一切，可我真的不知道这段黑暗的日子还要持续多久，我该怎么才能走出来啊……</p>
                                    <span class="text-blue-500 cursor-pointer" onclick="toggleCommentSection(1)">评论</span>
                                    <div class="comment-section" id="comment-section-1">
                                        <div class="mt-4">
                                            <textarea id="comment-input-1" class="comment-input" placeholder="写下你的评论..."></textarea>
                                            <button id="add-comment-1" class="comment-button">
                                                添加评论
                                            </button>
                                        </div>
                                        <div id="comment-list-1" class="comment-list">
                                            <!-- 评论条目将在这里动态添加 -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 帖子 2 -->
                        <div class="post-container">
                            <div class="flex space-x-4">
                                <div>
                                    <img src="./files/image/tx2.jpg" alt="User Avatar" class="user-avatar">
                                    <p class="user-id">软糖喵</p>
                                </div>
                                <div class="flex-1">
                                    <p class="post-content">分手之后，我才明白，原来最痛的不是分开的那一刻，而是分开后，生活中的每一个角落都还残留着你的影子。打开手机，聊天记录还没舍得删；路过常去的餐厅，还会习惯性地看向我们坐过的位置；看到好玩的事情，第一反应还是想分享给你，却突然想起我们已经分开了。我删掉了关于你的所有联系方式，可那些回忆却怎么也删不掉。我不断问自己，是不是我哪里做得不够好？是不是我太作了？我陷入了深深的自我怀疑和自责中，感觉自己快要被这些负面情绪淹没了。没有人能理解我的痛苦，我只能一个人默默地承受着，真的好累好累……</p>
                                    <span class="text-blue-500 cursor-pointer" onclick="toggleCommentSection(2)">评论</span>
                                    <div class="comment-section" id="comment-section-2">
                                        <div class="mt-4">
                                            <textarea id="comment-input-2" class="comment-input" placeholder="写下你的评论..."></textarea>
                                            <button id="add-comment-2" class="comment-button">
                                                添加评论
                                            </button>
                                        </div>
                                        <div id="comment-list-2" class="comment-list">
                                            <!-- 评论条目将在这里动态添加 -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 帖子 3 -->
                        <div class="post-container">
                            <div class="flex space-x-4">
                                <div>
                                    <img src="./files/image/tx3.jpg" alt="User Avatar" class="user-avatar">
                                    <p class="user-id">云小糯</p>
                                </div>
                                <div class="flex-1">
                                    <p class="post-content">曾经以为，我们会一直走下去，直到白头偕老。可现实却狠狠地给了我一巴掌，让我知道爱情是如此的脆弱。分手后，我尝试让自己忙起来，想用工作和社交填满生活，可每当夜深人静，孤独和思念就会如潮水般涌来。我开始失眠，开始变得敏感脆弱，一点点小事就能让我崩溃大哭。我不敢和家人朋友说太多，怕他们担心，只能把所有的委屈和痛苦都藏在心里。我真的好希望这只是一场噩梦，醒来后你还在我身边，我们还能像以前一样，说说笑笑，可我知道，这一切都回不去了，未来的路，我该怎么一个人走下去啊……</p>
                                    <span class="text-blue-500 cursor-pointer" onclick="toggleCommentSection(3)">评论</span>
                                    <div class="comment-section" id="comment-section-3">
                                        <div class="mt-4">
                                            <textarea id="comment-input-3" class="comment-input" placeholder="写下你的评论..."></textarea>
                                            <button id="add-comment-3" class="comment-button">
                                                添加评论
                                            </button>
                                        </div>                                        
                                        <div id="comment-list-3" class="comment-list">
                                            <!-- 评论条目将在这里动态添加 -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                </section>
            </div>
        </section>    
    <script src="./files/index.js"></script>
    <script src="./files/ajax.js"></script>
    <script src="./files/vanilla-tilt.js"></script>
        <div class="footer">
            <a href="https://beian.miit.gov.cn"><strong>&copy; 2025 MindHeaven. All rights reserved.     备案号：闽ICP备2025095319号</strong></font></a>
        </div> 
</body>

</html>
