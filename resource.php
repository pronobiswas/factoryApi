<?php
/**
 * Template Name: Resource Template
 * Description: A custom page template for displaying resources.
 */

get_header(); ?>

<div id="pro_resource" class="content-area">
    <main id="main" class="site-main">
        <div class="resource-content">
            <div class="forms">
                <form id="resourceForm" enctype="multipart/form-data">
                    <div class="document">
                        <label for="document">Document</label>
                        <input type="text" placeholder="Document" id="document" name="document">
                    </div>
                    <div class="version">
                        <label for="version">Version</label>
                        <input type="text" placeholder="Version" id="version" name="version">
                    </div>
                    <div class="content">
                        <input type="file" id="content" name="content">
                    </div>
                    <div class="submit">
                        <button type="submit" id="submit">Submit</button>
                    </div>
                </form>
            </div>
            <div class="pro_result">
                <div class="foermatedTxtContent">
                    <div class="firstText"></div>
                    <div class="allText"></div>
                </div>
                <div class="response">
                    <div class="segmentRow"></div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php get_footer(); ?>

<style>
#pro_resource {
    width: 100%;
    height: 100%;
}
#main {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}
.resource-content {
    width: 100%;
    display: flex;
    justify-content: center;
    gap: 30px;
}
.forms {
    width: 40%;
}
#resourceForm{
    width: 100%;
    display: flex;
    flex-direction:column;
    gap:10px
}
.pro_result {
    width: 60%;
}
.segmentRow {
    width: 100%;
}
.segmentTitlewrapper {
    padding: 8px;
    border-top: 1px solid black;
    border-bottom: 1px solid black;
}
.segmentHeading {
    display: flex;
    align-items: center;
    gap: 10px;
}
.segmentContent {
    padding-left: 20px;
    display: none;
}
.firstText{
    width: 100%;
    display: flex;
    justify-content: space-between;
}
.formatedText{
    margin:0;
    padding:0;
}
.segmentDetails{
    margin:0;
    padding:0;
}
</style>

<script>
document.getElementById('resourceForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
        const response = await fetch('<?php echo get_stylesheet_directory_uri(); ?>/proxy.php', {
            method: 'POST',
            body: formData,
        });

        const result = await response.text();
        const result1 = JSON.parse(result);
        console.log(result1);
        let textContent = result1.content || '';
        let splitedText = textContent.split('~');
        let firstText = splitedText[0];
        let formatedFirstText = firstText.split('          ');
        let textArray = splitedText.slice(1);

        formatedFirstText.forEach((text)=>{
            document.querySelector('.firstText').innerHTML += `<span class="formatedText"><b>${text}</b></span>`;
        });

        textArray.forEach((text)=>{
            document.querySelector('.allText').innerHTML += `<p class="formatedText">${text}</p>`;
        });

        
        
       

        

        // Display formatted content
        // document.querySelector('.foermatedTxtContent').innerHTML = result1.content || '';

        // Display response
        if (Array.isArray(result1.response)) {
            let html = '';

            result1.response.forEach((obj, idx) => {
                html += `
                    <div class="segmentTitlewrapper" data-idx="${idx}">
                        <div class="segmentHeading">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="black">
                                    <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
                                </svg>
                            </span>
                            <span class="segmentindicator">${obj.segement || ''}</span>
                            <span class="segmentTitle">${obj.name || ''}</span>
                        </div>
                        <div class="segmentContent"></div>
                    </div>
                `;
            });

            const segmentRow = document.querySelector('.segmentRow');
            segmentRow.innerHTML = html;

            // Event delegation to handle dynamic content click
            segmentRow.addEventListener('click', function(event) {
                const wrapper = event.target.closest('.segmentTitlewrapper');
                if (!wrapper) return;

                const idx = wrapper.getAttribute('data-idx');
                const segmentContent = wrapper.querySelector('.segmentContent');

                if (segmentContent.style.display === 'block') {
                    segmentContent.style.display = 'none';
                    segmentContent.innerHTML = '';
                    return;
                }

                // Show and populate segmentContent
                segmentContent.style.display = 'block';
                const clickedData = result1.response[idx]?.elements || [];

                segmentContent.innerHTML = clickedData.map(obj =>
                    `<p class="segmentDetails"><i>${obj.name}</i>: <b>${obj.value}</b></p>`
                ).join('');
            });
        }

    } catch (error) {
        console.error('Fetch error:', error);
    }
});
</script>
