document.addEventListener("DOMContentLoaded", function() {
    const desktopIcon = document.getElementById('desktopIcon');
    const mobileIcon = document.getElementById('mobileIcon');
   
    const templateFrames = document.querySelectorAll('.templateFrame');

    desktopIcon.addEventListener('click', function() {
        templateFrames.forEach(frame => {
            if (!frame.classList.contains('d-none')) {
                const templateSrc = frame.getAttribute('src');
                window.open('desktop_view.php?src=' + encodeURIComponent(templateSrc), '_blank');
            }
        });
    });

    mobileIcon.addEventListener('click', function() {
        templateFrames.forEach(frame => {
            if (!frame.classList.contains('d-none')) {
                const templateSrc = frame.getAttribute('src');
                window.open('mobile_view.php?src=' + encodeURIComponent(templateSrc), '_blank');
            }
        });
    });


    const urlParams = new URLSearchParams(window.location.search);
    const viewMode = urlParams.get('viewMode');

    if (viewMode === 'desktop' || viewMode === 'mobile') {
        closeIcon.classList.remove('hidden');
    }

    const firstRadioButton = document.querySelector('.card input[type="radio"]');
    if (firstRadioButton) {
        firstRadioButton.checked = true;
        document.querySelector('.btn-next').disabled = false;
        userData.template = "../Templates/" + firstRadioButton.value + "/index.php";
        updateSelectedTemplate();
    }

});

// CUSTOM SELECT ELEMENT
let userData = {
    storeName: '',
    storeLogo: '',
    template: ''
};


document.getElementById('continueButton').addEventListener('click', function () {
    const categorySection = document.getElementById('categorySection');
    const nameSection = document.getElementById('nameSection');
    const selectedCategory = document.querySelector('#customSelectValue').value;

    if (selectedCategory) {
        categorySection.classList.add('d-none');
        nameSection.classList.remove('d-none');
    }
});

document.getElementById('continueNameButton').addEventListener('click', function () {
    const nameSection = document.getElementById('nameSection');
    const logoSection = document.getElementById('logoSection');
    const storeName = document.getElementById('storeName').value;

    if (storeName) {
       
        fetch('check_store_name.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `storeName=${encodeURIComponent(storeName)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data) {
                alert('Store name already taken. Please select another name.');
            } else {
                userData.storeName = storeName;
                nameSection.classList.add('d-none');
                logoSection.classList.remove('d-none');
                updatePreview();
            }
        })
        .catch(error => console.error('Error:', error));
    }
});

document.getElementById('storeLogo').addEventListener('change', function () {
    const logoInput = document.getElementById('storeLogo');
    const reader = new FileReader();
    
    reader.onload = function (e) {
        userData.storeLogo = e.target.result;
        updatePreview();
    };
    
    if (logoInput.files && logoInput.files[0]) {
        reader.readAsDataURL(logoInput.files[0]);
    }
});

document.getElementById('continueLogoButton').addEventListener('click', function () {
    const logoSection = document.getElementById('logoSection');
    const templateSection = document.getElementById('templateSection');
    const iframeSection = document.querySelector('.iframe-cont-old');
    const templateSectioniframe = document.querySelector('.template_sec_cont');
    
    logoSection.classList.add('d-none');
    iframeSection.classList.add('d-none');
    templateSection.classList.remove('d-none');
    templateSectioniframe.classList.remove('d-none');
});

function updatePreview() {
    const previewFrame = document.getElementById('previewFrame');
    const previewDoc = previewFrame.contentWindow.document;

    // Update the title within the iframe
    previewDoc.title = userData.storeName;
    previewDoc.getElementById('storeNameBanner').innerText = userData.storeName;

    if (userData.storeLogo) {
        const previewLogo = previewDoc.getElementById('previewLogo');
        previewLogo.src = userData.storeLogo;
        previewLogo.style.display = 'block';
    }

    // Update all template frames
    document.querySelectorAll('.templateFrame').forEach((templateFrame) => {

        const templateDoc = templateFrame.contentWindow.document;
        

        templateDoc.title = userData.storeName;

        if (userData.storeLogo) {
            const templateLogo = templateDoc.getElementById('previewLogo');
            templateLogo.src = userData.storeLogo;
            templateLogo.style.display = 'block';
        }
    });
}

// Back button functionality
// Back button in name section
document.getElementById('backNameButton').addEventListener('click', function () {
    document.getElementById('nameSection').classList.add('d-none');
    document.getElementById('categorySection').classList.remove('d-none');
});

// Back button in logo section
document.getElementById('backLogoButton').addEventListener('click', function () {
    document.getElementById('logoSection').classList.add('d-none');
    document.getElementById('nameSection').classList.remove('d-none');
});

// Back button in template section
document.getElementById('backTemplateButton').addEventListener('click', function () {
    document.getElementById('templateSection').classList.add('d-none');
    document.getElementById('logoSection').classList.remove('d-none');
});


document.querySelectorAll('.card').forEach((card) => {
    card.addEventListener('click', function (event) {
        selectTemplate(event);
    });
});

function selectTemplate(event) {
    const cardElement = event.currentTarget;
    if (!cardElement) {
        console.error('Current target element is undefined.');
        return;
    }

    const radioButton = cardElement.querySelector('input[type="radio"]');
    if (!radioButton) {
        console.error('Radio button not found within the card element.');
        return;
    }
    const templatePrev = "../Templates/" + radioButton.value + "/index.php";

    document.querySelectorAll('.card input[type="radio"]').forEach(rb => {
        const hiddenInput = rb.closest('.card').querySelector('.preview-image-url');
        rb.checked = false;
        if (hiddenInput) {
            hiddenInput.value = '';
            hiddenInput.removeAttribute('name');
        }
    });

    radioButton.checked = true;
    const selectedImgElement = cardElement.querySelector('.card-img-top');
    if (selectedImgElement) {
        
        const hiddenInput = cardElement.querySelector('.preview-image-url');
        if (hiddenInput) {
            hiddenInput.setAttribute('name', 'preview_image');
            hiddenInput.value = selectedImgElement.src;
        }
    }
    document.querySelector('.btn-next').disabled = false;
    userData.template = templatePrev;
    updateSelectedTemplate();
}

function updateSelectedTemplate() {
   
    document.querySelectorAll('.templateFrame').forEach((frame) => {
        frame.classList.add('d-none');
    });


    const selectedFrame = document.querySelector(`.templateFrame[src="${userData.template}"]`);
    if (selectedFrame) {
        selectedFrame.classList.remove('d-none');
        const templateDoc = selectedFrame.contentWindow.document;
        
        templateDoc.title = userData.storeName;

        if (userData.storeLogo) {
            const templateLogo = templateDoc.getElementById('previewLogo');
            templateLogo.src = userData.storeLogo;
            templateLogo.style.display = 'block';
        }
    }
}

document.querySelectorAll('.dropdown-item').forEach((item) => {
    item.addEventListener('click', function (event) {
        document.getElementById('customSelectValue').value = event.target.getAttribute('data-value');
        document.getElementById('customSelect').textContent = event.target.getAttribute('data-value');
    });
});



