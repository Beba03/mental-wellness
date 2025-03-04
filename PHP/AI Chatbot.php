<?php
include("headerlogic.php");
include("Header.php");

$userName = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mental Wellness</title>
    <link rel="stylesheet" href="../CSS/ai chatbot.css">
</head>

<script>

    var loggedInUserName = "<?php echo htmlspecialchars($userName); ?>";

    async function sendGreeting() {
        appendMessage("AI", "Hello " + loggedInUserName + "! How are you feeling today?");
    }

    async function sendMessage() {
        const userInput = document.getElementById("user-input").value;
        if (!userInput.trim()) return;

        // Display user message
        appendMessage("You", userInput);

        // Show the "three dots" bubble for the AI while retrieving data
        const aiBubble = appendMessage("AI", "<div class='ai-bubble'><div class='dots'><div class='dot'></div><div class='dot'></div><div class='dot'></div></div></div>");

        try {
            const response = await fetch("getAIResponse.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ userInput }),
            });

            const data = await response.json();
            console.log("API Response:", data);

            let aiResponse = data.candidates?.[0]?.content?.parts?.[0]?.text || "I'm not sure about that.";

            // Format response: Add line breaks for readability
            aiResponse = aiResponse.replace(/\n/g, "<br>");

            // Ensure bullet points are properly formatted
            aiResponse = aiResponse.replace(/•\s?/g, "<br>• ");

            // Remove the three dots bubble when a response is generated
            aiBubble.remove();
            appendMessage("AI", aiResponse);
        } catch (error) {
            console.error("Error fetching AI response:", error);
            aiBubble.remove();
            appendMessage("AI", "Error retrieving response.");
        }

        document.getElementById("user-input").value = "";
    }

    function appendMessage(sender, message) {
        const chatBox = document.getElementById("chat-box");
        const messageElement = document.createElement("div");

        // Add a class for the message type
        const messageClass = sender === "You" ? "user-message" : "ai-message";

        messageElement.classList.add("message", messageClass);
        messageElement.innerHTML = message;

        chatBox.appendChild(messageElement);

        // Scroll to bottom
        chatBox.scrollTop = chatBox.scrollHeight;

        return messageElement;
    }

    // Send the greeting on page load
    window.onload = function() {
        sendGreeting();
    };
</script>

<div class="chat-container">
    <div id="chat-box"></div>
    <div class="input-container">
        <input type="text" id="user-input" placeholder="Type your message...">
        <button onclick="sendMessage()">Send</button>
    </div>
</div>

<?php
include("../HTML/Footer.html");
?>
