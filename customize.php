<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customizable Page</title>
</head>
<style>
body, html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
}

.customizer {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100vh;
    background-color: #fff;
    border-right: 1px solid #ddd;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    overflow-y: auto;
}

.customizer label {
    display: block;
    margin-top: 10px;
}

.customizer input, select {
    width: 100%;
    margin-bottom: 10px;
}

.customizer button {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
}

.customizer button:hover {
    background-color: #0056b3;
}

.content {
    margin-left: 20rem;
    padding: 20px;
}

.content h1, .content p {
    margin: 20px 0;
}

.content button {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
}

.content button:hover {
    background-color: #0056b3;
}
</style>
<body>

<div class="customizer">
        <h2>Customizer</h2>
        <label for="headingColor">Heading Color:</label>
        <input type="color" id="headingColor">
        <label for="paragraphColor">Paragraph Color:</label>
        <input type="color" id="paragraphColor">
        <label for="headingFontSize">Heading Font Size:</label>
        <input type="number" id="headingFontSize" min="10" max="100" value="32">
        <label for="paragraphFontSize">Paragraph Font Size:</label>
        <input type="number" id="paragraphFontSize" min="10" max="100" value="16">
        <label for="buttonColor">Button Color:</label>
        <input type="color" id="buttonColor">
        <label for="bgColor">Background Color:</label>
        <input type="color" id="bgColor">
        <!-- <label for="textBgColor">Text Background Color:</label> -->
        <label for="headingFontFamily">Heading Font Family:</label>
        <select id="headingFontFamily">
            <option value="Arial">Arial</option>
            <option value="Georgia">Georgia</option>
            <option value="Times New Roman">Times New Roman</option>
        </select>
        
        <label for="paragraphFontFamily">Paragraph Font Family:</label>
        <select id="paragraphFontFamily">
            <option value="Arial">Arial</option>
            <option value="Georgia">Georgia</option>
            <option value="Times New Roman">Times New Roman</option>
        </select>
        <input type="color" id="textBgColor">
        <button id="saveBtn">Save</button>
    </div>
    <div class="content">
        <h1 contenteditable="true">Editable Heading</h1>
        <p contenteditable="true">This is an editable paragraph. You can change the text and the style using the customizer.</p>
        <button>Sample Button</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const heading = document.querySelector('.content h1');
            const paragraph = document.querySelector('.content p');
            const button = document.querySelector('.content button');

            const headingColorInput = document.getElementById('headingColor');
            const paragraphColorInput = document.getElementById('paragraphColor');
            const headingFontSizeInput = document.getElementById('headingFontSize');
            const paragraphFontSizeInput = document.getElementById('paragraphFontSize');
            const buttonColorInput = document.getElementById('buttonColor');
            const bgColorInput = document.getElementById('bgColor');
            const textBgColorInput = document.getElementById('textBgColor');
            const saveBtn = document.getElementById('saveBtn');

        function applyCustomizations() {
            const headingColor = localStorage.getItem('headingColor');
            const paragraphColor = localStorage.getItem('paragraphColor');
            const headingFontSize = localStorage.getItem('headingFontSize');
            const paragraphFontSize = localStorage.getItem('paragraphFontSize');
            const buttonColor = localStorage.getItem('buttonColor');
            const bgColor = localStorage.getItem('bgColor');
            const textBgColor = localStorage.getItem('textBgColor');
            const headingText = localStorage.getItem('headingText');
            const paragraphText = localStorage.getItem('paragraphText');

            if (headingColor) heading.style.color = headingColor;
            if (paragraphColor) paragraph.style.color = paragraphColor;
            if (headingFontSize) heading.style.fontSize = `${headingFontSize}px`;
            if (paragraphFontSize) paragraph.style.fontSize = `${paragraphFontSize}px`;
            if (buttonColor) button.style.backgroundColor = buttonColor;
            if (bgColor) document.body.style.backgroundColor = bgColor;
            if (textBgColor) {
                heading.style.backgroundColor = textBgColor;
                paragraph.style.backgroundColor = textBgColor;
            }
            if (headingText) heading.innerText = headingText;
            if (paragraphText) paragraph.innerText = paragraphText;

            headingColorInput.value = headingColor || '#000000';
            paragraphColorInput.value = paragraphColor || '#000000';
            headingFontSizeInput.value = headingFontSize || '32';
            paragraphFontSizeInput.value = paragraphFontSize || '16';
            buttonColorInput.value = buttonColor || '#007bff';
            bgColorInput.value = bgColor || '#f0f0f0';
            textBgColorInput.value = textBgColor || '#ffffff';
        }

        function saveCustomizations() {
            localStorage.setItem('headingColor', headingColorInput.value);
            localStorage.setItem('paragraphColor', paragraphColorInput.value);
            localStorage.setItem('headingFontSize', headingFontSizeInput.value);
            localStorage.setItem('paragraphFontSize', paragraphFontSizeInput.value);
            localStorage.setItem('buttonColor', buttonColorInput.value);
            localStorage.setItem('bgColor', bgColorInput.value);
            localStorage.setItem('textBgColor', textBgColorInput.value);
            localStorage.setItem('headingText', heading.innerText);
            localStorage.setItem('paragraphText', paragraph.innerText);
            applyCustomizations();
        }

        headingColorInput.addEventListener('input', () => {
            heading.style.color = headingColorInput.value;
        });

        paragraphColorInput.addEventListener('input', () => {
            paragraph.style.color = paragraphColorInput.value;
        });

        headingFontSizeInput.addEventListener('input', () => {
            heading.style.fontSize = `${headingFontSizeInput.value}px`;
        });

        paragraphFontSizeInput.addEventListener('input', () => {
            paragraph.style.fontSize = `${paragraphFontSizeInput.value}px`;
        });

        buttonColorInput.addEventListener('input', () => {
            button.style.backgroundColor = buttonColorInput.value;
        });

        bgColorInput.addEventListener('input', () => {
            document.body.style.backgroundColor = bgColorInput.value;
        });

        textBgColorInput.addEventListener('input', () => {
            heading.style.backgroundColor = textBgColorInput.value;
            paragraph.style.backgroundColor = textBgColorInput.value;
        });

        saveBtn.addEventListener('click', saveCustomizations);

        applyCustomizations();
    });

    document.addEventListener('DOMContentLoaded', function () {
    const heading = document.querySelector('.content h1');
    const paragraph = document.querySelector('.content p');
document.getElementById('headingFontFamily').addEventListener('change', function () {
        heading.style.fontFamily = this.value;
    });
    
    document.getElementById('paragraphFontFamily').addEventListener('change', function () {
        paragraph.style.fontFamily = this.value;
    });
});
    </script>
</body>
</html>
