<?php
require "dbconn.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" href="index.css">
    <title>Remidi Web Programming</title>
</head>
<body>
    <div class="judul">
        <h1>TO DO LIST APP</h1>
        <h3>Defi Andriani Web Programming</h3>
    </div>
    <div class="main-session">
        <div class="tambah-session">
            <form action="tambah.php" method="POST" autocomplete="off">
                <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                <input type="text" name="title" placeholder="Apa yang akan anda lakukan?">
                <button type="submit">Tambah</button>
                <?php }else{ ?>
                <input type="text" 
                    name="title" 
                    placeholder="Apa yang akan anda lakukan?" />
                <button type="submit">Tambah</span></button>
                <?php } ?>
            </form>
        </div>
        <?php
            $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
        ?>
        <div class="tampilkan-todo">
            <?php if($todos->rowCount() === 0 ){ ?>
                <div class="todo-item">
                    <input type="checkbox">
                    <h2>Testing</h2>
                    <br>
                    <p>12/1/2023</p>
                </div>
            <?php  } ?>

            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                    <span id="<?php echo $todo['id']; ?>"
                        class="remove-to-do">x</span>
                    <?php if($todo['checked']){ ?> 
                        <input type="checkbox"
                            class="check-box"
                            data-todo-id ="<?php echo $todo['id']; ?>"
                            checked />
                        <h2 class="checked"><?php echo $todo['title'] ?></h2>
                    <?php }else { ?>
                        <input type="checkbox"
                            data-todo-id ="<?php echo $todo['id']; ?>"
                            class="check-box" />
                        <h2><?php echo $todo['title'] ?></h2>
                    <?php } ?>
                    <br>
                    <small>Dibuat: <?php echo $todo['date_time'] ?></small> 
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="footer-container">
        <div class="footer">
            <h4>Dibuat Dengan Menggunakan</h4>
            <ul class="tool">
                <li>PHP</li>
                <li>MYSQL</li>
                <li>HTML</li>
                <li>CSS</li>
            </ul>
        </div>
    </div>
    


    <script src="jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.remove-to-do').click(function(){
                const id = $(this).attr('id');
                $.post("hapus.php",
                {
                    id: id
                },
                (data)  => {
                    if(data){
                        $(this).parent().hide(600);
                    }
                })
            });
            $(".check-box").click(function(e){
                const id = $(this).attr('data-todo-id');
                
                $.post('selesai.php', 
                    {
                        id: id
                    },
                    (data) => {
                        if(data != 'error'){
                            const h2 = $(this).next();
                            if(data === '1'){
                                h2.removeClass('checked');
                            }else {
                                h2.addClass('checked');
                            }
                        }
                    }
                );
            });
        });
    </script>
</body>
</html>