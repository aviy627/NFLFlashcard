<!DOCTYPE html>
<html>
    <head>
        <style>
            h1, h2 {
                text-align: center;
            }

            img {
                height: 300px;
            }

            div {
                text-align: center;
                padding: 10px;
            }

            input {
                margin: 5px;
            }

            .correct {
                border-color: green;
            }

            .wrong {
                border-color: red;
            }
        </style>
        <script>
            var answer = "";
            var questionNum = 0;
                    
            function showHint() {
                if(questionNum == 0){
                    document.getElementById("hint").innerHTML = "You have to have a question to have an answer... Dumbass";
                }
                else{   
                    document.getElementById("hint").innerHTML = "Answer: " + names[questionNum-1];
                }
            }
            
            function nextButton(){
                if(questionNum==0){
                    document.getElementById("next").setAttribute("value", "Next");
                }
                questionNum++;
                setButtons();
                document.getElementById("outOf").innerHTML = questionNum;
                document.getElementById("picture").setAttribute("src", urls[questionNum-1]);
            }
            
            function getRand(min, max, not){
                var rand = Math.floor((Math.random() * max) + min);
                
                while (rand == not){
                    rand = Math.floor((Math.random() * max) + min);
                }
                
                return rand;
            }
            
            function setButtons(){
                
                var answerButton = getRand(1, 4, -1);
                
                for(var i = 1; i <= 4; i++){
                    if(i == answerButton){
                        document.getElementById("button"+i).setAttribute("value", names[questionNum-1]);
                    }
                    else{
                        document.getElementById("button"+i).setAttribute("value", names[getRand(0, names.length, questionNum-1)]);
                    }
                }
                
            }
            
            function checkAnswer(obj){
                window.alert(obj.value);
            }

            </script>
    </head>

    <body>
    <?php
        $user = "root";
        $pword = "";
        $dbase = "FlashCards";
        $table = "Cars";
        print ("  <h1>$table</h1>\n");
        print ("  <div>\n");
        $mydb = new mysqli('localhost', $user, $pword, $dbase);
        if ($mydb->connect_error) {
          die( "Failed to connect to MySQL: " . $mydb->connect_error);
        }

        $answer = "SELECT name, url FROM $table ORDER BY rand()";

        $result = $mydb->query($answer);

        $mydb->close();

        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        $names = array_column($row, "name");
        
        $urls = array_column($row, "url");
           

    ?>
        <script>
            var names = <?php echo json_encode($names); ?>;
            var urls = <?php echo json_encode($urls); ?>;
        </script>
        <form>
            <div>
                <img id="picture" src="">
            </div>
            <div>
                <input id ="button1"type="button" value="" onClick="checkAnswer(this)">
                <input id ="button2"type="button" value="">
                <input id ="button3"type="button" value="">
                <input id ="button4"type="button" value="">
            </div>
            <div>
              <input id="show" type="button" value="Answer" onClick="showHint()">
              <span id="score">0</span> / <span id="outOf">0</span>
              <input id="next" type="button" value="Start" onClick="nextButton()">
            </div>
      </form>
        <h2 id="hint"></h2>
        <h3 id="names"></h3>

    </body>

</html>

