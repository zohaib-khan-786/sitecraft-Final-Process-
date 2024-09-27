<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customizable Page</title>
</head>
<style>body, html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

.customizer {
    position: fixed;
    top: 0;
    left: 0;
    width: 200px;
    padding: 20px;
    background: #f0f0f0;
    border-right: 1px solid #ddd;
}

.customizer label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.customizer input, .customizer select {
    display: block;
    margin-bottom: 15px;
    width: 100%;
    padding: 5px;
}

.content {
    margin-left: 220px;
    padding: 20px;
}

.content h1, .content p {
    margin-bottom: 20px;
}
</style>
<body>
    <div class="customizer">
        <label for="headingColor">Heading Color:</label>
        <input type="color" id="headingColor">
        
        <label for="paragraphColor">Paragraph Color:</label>
        <input type="color" id="paragraphColor">
        
        <label for="headingFontSize">Heading Font Size:</label>
        <input type="number" id="headingFontSize" value="32">
        
        <label for="paragraphFontSize">Paragraph Font Size:</label>
        <input type="number" id="paragraphFontSize" value="16">
        
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
    </div>
    
    <div class="content">
        <h1 contenteditable="true">Editable Heading</h1>
        <p contenteditable="true">Editable paragraph text goes here.</p>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const heading = document.querySelector('.content h1');
    const paragraph = document.querySelector('.content p');
    
    document.getElementById('headingColor').addEventListener('input', function () {
        heading.style.color = this.value;
    });
    
    document.getElementById('paragraphColor').addEventListener('input', function () {
        paragraph.style.color = this.value;
    });
    
    document.getElementById('headingFontSize').addEventListener('input', function () {
        heading.style.fontSize = this.value + 'px';
    });
    
    document.getElementById('paragraphFontSize').addEventListener('input', function () {
        paragraph.style.fontSize = this.value + 'px';
    });
    
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