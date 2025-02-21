<?php
include("headerlogic.php");
include("Header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mental Wellness</title>
    <link rel="stylesheet" href="../CSS/ai chatbot.css">
</head>

<body onload="sendGreeting()">


    <script>
        const API_KEY = "AIzaSyCL47TmTxvUzlFEZnoODoIsG7mO5wuSink";

        // Send an automatic greeting message on page load without triggering a response
        async function sendGreeting() {
            // Greeting message from AI (without user input)
            appendMessage("AI", "Hello! How can I assist you today?");
        }

        // Send a user message and get a response from AI
        async function sendMessage() {
            const userInput = document.getElementById("user-input").value;
            if (!userInput.trim()) return; // Prevent sending empty messages

            // Display user's message
            appendMessage("You", userInput);

            const url = `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${API_KEY}`;
            const requestData = {
                contents: [{
                    role: "user",
                    parts: [{
                        text: `You are a mental health AI. Provide a reassuring and positive response to the following user input, without providing phone numbers of different departments and without stating you can't give medical advice: ${userInput}`
                    }]
                }]
            };

            try {
                const response = await fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(requestData)
                });

                const data = await response.json();
                console.log("API Response:", data);

                // Get AI response
                const aiResponse = data.candidates?.[0]?.content?.parts?.[0]?.text || "I'm not sure about that.";
                appendMessage("AI", aiResponse);

            } catch (error) {
                console.error("Error fetching AI response:", error);
                appendMessage("AI", "Error retrieving response.");
            }

            // Clear input field
            document.getElementById("user-input").value = "";
        }

        function appendMessage(sender, message) {
            const chatBox = document.getElementById("chat-box");
            const messageElement = document.createElement("p");
            messageElement.innerHTML = `<strong>${sender}:</strong> ${message}`;
            chatBox.appendChild(messageElement);

            // Scroll to bottom
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        // Send the greeting on page load
        window.onload = function() {
            sendGreeting(); // Send a greeting from AI automatically when the page loads
        };
    </script>

    <div class="chat-container">
        <div id="chat-box"></div> <!-- AI Responses appear here -->
        <div class="input-container">
            <input type="text" id="user-input" placeholder="Type your message...">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>
</body>

</html>

<?php
include("..\HTML\Footer.html");
?>