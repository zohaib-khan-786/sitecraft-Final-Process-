function setTheme(theme) {
    let variables;

    switch (theme) {
        case '1':
            variables = {

                '--white': '#ffffff',
                '--black': '#000000',
                '--primary1': '#f89cab',
                '--btnColor': '#db4f66',
                '--secondary': '#f0e68c', // Light yellow
                '--accent': '#ff6f61',     // Coral
                'font-family': 'Arial, sans-serif'
            };
            break;
        case '2':
            variables = {

                '--white': '#f0f0f0',
                '--black': '#222222',
                '--primary1': '#f7c6c7',
                '--btnColor': '#c55a68',
                '--secondary': '#b2d3c2', // Soft teal
                '--accent': '#ff4a4a',     // Bright red
                'font-family': "'Roboto', sans-serif"
            };
            break;
        case '3':
            variables = {

                '--white': '#eaeaea',
                '--black': '#333333',
                '--primary1': '#d5a5d4',
                '--btnColor': '#ab4a91',
                '--secondary': '#ffcccb', // Soft pink
                '--accent': '#79589f',     // Lavender
                'font-family': "'Georgia', serif"
            };
            break;
        case '4':
            variables = {

                '--white': '#ffffff',
                '--black': '#444444',
                '--primary1': '#d9cba2',
                '--btnColor': '#a15e3b',
                '--secondary': '#f6e58d', // Pale yellow
                '--accent': '#ff7979',     // Salmon
                'font-family': "'Times New Roman', serif"
            };
            break;
        case '5':
            variables = {

                '--white': '#fffbf0',
                '--black': '#3a3a3a',
                '--primary1': '#ff8c00',
                '--btnColor': '#f55a1a',
                '--secondary': '#ffeaa7', // Light yellow
                '--accent': '#d63031',     // Dark red
                'font-family': "'Montserrat', sans-serif"
            };
            break;
        case '6':
            variables = {

                '--white': '#ffffff',
                '--black': '#1f1f1f',
                '--primary1': '#f2a900',
                '--btnColor': '#f24e00',
                '--secondary': '#fdcb6e', // Soft gold
                '--accent': '#e17055',     // Soft orange
                'font-family': "'Open Sans', sans-serif"
            };
            break;
        case '7':
            variables = {

                '--white': '#fff9e6',
                '--black': '#6f6f6f',
                '--primary1': '#ffcc99',
                '--btnColor': '#e68a00',
                '--secondary': '#f8a5c2', // Light pink
                '--accent': '#ff6b81',     // Coral pink
                'font-family': "'Lora', serif"
            };
            break;
        case '8':
            variables = {

                '--white': '#f5f5f5',
                '--black': '#404040',
                '--primary1': '#7d9ec0',
                '--btnColor': '#3c5a7e',
                '--secondary': '#dfe6e9', // Soft gray
                '--accent': '#0984e3',     // Bright blue
                'font-family': "'Poppins', sans-serif"
            };
            break;
        default:
            variables = {

                '--white': '#ffffff',
                '--black': '#000000',
                '--primary1': '#f89cab',
                '--btnColor': '#db4f66',
                '--secondary': '#f0e68c',
                '--accent': '#ff6f61',
                'font-family': 'Arial, sans-serif'
            };
    }

    fetch('dashboard_theme_handle.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(variables),
    }).then(response => {
        if (response.ok) {
            const currentSrc = $('#previewFrame').attr('src');
            $('#previewFrame').attr('src', currentSrc);
        }
    });
}


const themes = [
    {
        name: '1',
        displayName: 'Placid',
        description: 'Calm & easygoing',
        colors: ['#ffffff', '#000000', '#f89cab', '#db4f66', '#f0e68c', '#ff6f61'],
        font: 'Arial, sans-serif'
    },
    {
        name: '2',
        displayName: 'Fashionable',
        description: 'Trendy & stylish',
        colors: ['#f0f0f0', '#222222', '#f7c6c7', '#c55a68', '#b2d3c2', '#ff4a4a'],
        font: "'Roboto', sans-serif"
    },
    {
        name: '3',
        displayName: 'Bohemian',
        description: 'Creative & artistic',
        colors: ['#eaeaea', '#333333', '#d5a5d4', '#ab4a91', '#ffcccb', '#79589f'],
        font: "'Georgia', serif"
    },
    {
        name: '4',
        displayName: 'Mature',
        description: 'Sophisticated & elegant',
        colors: ['#ffffff', '#444444', '#d9cba2', '#a15e3b', '#f6e58d', '#ff7979'],
        font: "'Times New Roman', serif"
    },
    {
        name: '5',
        displayName: 'Tangy',
        description: 'Vibrant & bold',
        colors: ['#fffbf0', '#3a3a3a', '#ff8c00', '#f55a1a', '#ffeaa7', '#d63031'],
        font: "'Montserrat', sans-serif"
    },
    {
        name: '6',
        displayName: 'Vivid',
        description: 'Bright & lively',
        colors: ['#ffffff', '#1f1f1f', '#f2a900', '#f24e00', '#fdcb6e', '#e17055'],
        font: "'Open Sans', sans-serif"
    },
    {
        name: '7',
        displayName: 'Creamy',
        description: 'Soft & inviting',
        colors: ['#fff9e6', '#6f6f6f', '#ffcc99', '#e68a00', '#f8a5c2', '#ff6b81'],
        font: "'Lora', serif"
    },
    {
        name: '8',
        displayName: 'Laid-back',
        description: 'Relaxed & easygoing',
        colors: ['#f5f5f5', '#404040', '#7d9ec0', '#3c5a7e', '#dfe6e9', '#0984e3'],
        font: "'Poppins', sans-serif"
    }
];

themes.forEach(theme => {
    let ul = document.getElementById('themeList');
    let li = document.createElement('li');
    li.innerHTML = `
    <li class="mb-2">
        <div class='card card-dark p-1 theme-btn' data-theme='${theme.name}' style="background-color: ${theme.colors[2]};">
            <div class='card-body d-flex align-items-center justify-content-between gap-1'>
                <div style="color: ${theme.colors[1]};">
                    <h5 class='card-title mb-1 fw-bold' style=" font-size: 16px;">${theme.displayName}</h5>
                    <p class='card-text mt-0'><small style="font-size: 12px;">${theme.description}</small></p>
                </div>
                <div>
                    <span class='color-box' style='background-color: ${theme.colors[0]};'></span>
                    <span class='color-box' style='background-color: ${theme.colors[1]};'></span>
                    <span class='color-box' style='background-color: ${theme.colors[2]}; border: 1.5px solid ${theme.colors[1]};'></span>
                    <span class='color-box' style='background-color: ${theme.colors[3]};'></span>
                    <span class='color-box' style='background-color: ${theme.colors[4]};'></span>
                    <span class='color-box' style='background-color: ${theme.colors[5]};'></span>
                </div>
            </div>
        </div>
    </li>`;
    
    ul.appendChild(li);
})

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.theme-btn').forEach(button => {
        button.addEventListener('click', function() {
            const theme = this.getAttribute('data-theme');
            setTheme(theme);
            
            fetch('dashboard_theme_handle.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ theme: theme })
            }).then(response => {
                if (!response.ok) {
                    console.error('Failed to update the theme.');
                }
            });
        });
    });

});