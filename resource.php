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

        </div>
        <div class="pro_result"></div>
</div>

</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
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
        let result1 = await JSON.parse(result);
        console.log(result1);
        document.querySelector('.pro_result').innerHTML = '<pre>'
    } catch (error) {
       console.log(error);
       
    }
});
</script>