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
                        <label for="content">Content</label>
                        <input type="file" placeholder="Content" id="content" name="content">
                    </div>
                    <div class="submit">
                        <button type="submit" id="submit">Submit</button>
                    </div>
                </form>
            </div>
            <div class="pro_result">
                <div class="content"></div>

                <div class="response">
                    <div class="segmentRow">
                        <!-- <div class="segmentTitlewrapper">
                            <span><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="black">
                                    <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
                                </svg></span>
                            <span class="segmentindicator">SA</span>
                            <span class="segmentTitle">Lorem ipsum dolor sit</span>
                        </div> -->
                    </div>
                </div>

            </div>
        </div>
</div>

</main><!-- #main -->
</div><!-- #primary -->

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
    height: 100%;
    display: flex;
    justify-content: center;
}

.forms {
    width: 40%;
}

.pro_result {
    width: 60%;
}

.segmentRow {
    width: 100%;
}

.segmentTitlewrapper {
    width: 100%;
    display: flex;
    align-items: center;
    padding: 8px;
    border-top: 1px solid black;
    border-bottom: 1px solid black;
    border-left: none;
    border-right: none;
}
</style>
<script>
document.getElementById('resourceForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    try {
        const response = await fetch('<?php echo get_stylesheet_directory_uri(); ?>/proxy.php', {
            method: 'POST',
            body: formData,
        });

        const result = await response.text();
        let result1 = JSON.parse(result);
        console.log(result1);

        document.querySelector('.content').innerHTML = result1.content || '';

        if (Array.isArray(result1.response)) {
            let html = '';
            result1.response.forEach((obj,idx) => {
                html += `
        <div class="segmentTitlewrapper" data-idx="${idx}">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                    width="24px" fill="black">
                    <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
                </svg>
            </span>
            <span class="segmentindicator">${obj.segement || ''}</span>
            <span class="segmentTitle">${obj.name || ''}</span>
        </div>
        `;
            });
            document.querySelector('.segmentRow').innerHTML = html;

        }
    } catch (error) {
        console.log(error);

    }
});
let segmentRow = document.querySelector('.segmentRow');
segmentRow.addEventListener('click',(e)=>{
    console.log(e.target);
    
});


</script>