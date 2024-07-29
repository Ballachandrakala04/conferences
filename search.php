<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Continuous Typing and Reversing Effect</title>
    <style>
        /* CSS for typed cursor effect */
        #myInput {
            border: 1px solid #ccc;
            padding: 8px;
            width: 300px;
            font-size: 16px;
        }
        .typing-cursor {
            border-right: 2px solid black;
            animation: blink 0.7s steps(44) infinite normal;
        }
        @keyframes blink {
            50% {
                border-color: transparent;
            }
        }
    </style>
</head>
<body>
    <input type="text" id="myInput" class="typing-cursor" placeholder="Typing...">

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            // Function to start typing effect
            function startTypingEffect(texts) {
                let textIndex = 0;
                let charIndex = 0;
                let isDeleting = false;

                function typeWriter() {
                    const currentText = texts[textIndex];
                    const displayText = isDeleting ? currentText.substring(0, charIndex--) : currentText.substring(0, charIndex++);

                    $('#myInput').val(displayText);

                    if (!isDeleting && charIndex === currentText.length) {
                        setTimeout(() => {
                            isDeleting = true;
                            setTimeout(typeWriter, 100);
                        }, 1000); // Pause before deleting
                    } else if (isDeleting && charIndex === 0) {
                        isDeleting = false;
                        textIndex = (textIndex + 1) % texts.length; // Move to the next text
                        setTimeout(typeWriter, 500); // Pause before typing the next text
                    } else {
                        setTimeout(typeWriter, 100); // Adjust typing speed here
                    }
                }

                typeWriter();
            }

            // Fetch data from the PHP script via AJAX
            $.ajax({
                url: 'getText.php',
                method: 'GET',
                success: function(data) {
                    startTypingEffect(data);
                }
            });
        });
    </script>
</body>
</html>
