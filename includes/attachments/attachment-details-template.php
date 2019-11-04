<script type="text/html" id="tmpl-attachment-details_jfm">
    <h2>
        <?php _e( 'Attachment Details' ); ?>
        <span class="settings-save-status">
            <span class="spinner"></span>
            <span class="saved"><?php esc_html_e( 'Saved.' ); ?></span>
        </span>
    </h2>
    <div class="attachment-info">
    <# if ( 'audio' !== data.type ) { #>
        <div class="thumbnail thumbnail-{{ data.type }}">
            <# if ( data.uploading ) { #>
                <div class="media-progress-bar"><div></div></div>
            <# } else if ( 'image' === data.type && data.sizes ) { #>
                <img src="{{ data.size.url }}" draggable="false" alt="" />
            <# } else { #>
                <img src="{{ data.icon }}" class="icon" draggable="false" alt="" />
            <# } #>
        </div>
    <# } #>
    <# var maybeReadOnly = data.can.save || data.allowLocalEdits ? '' : 'readonly'; #>
    <# if ( 'image' === data.type ) { #>
        <label class="setting" data-setting="alt">
            <span class="name"><?php _e( 'Alt Text' ); ?></span>
            <input type="text" value="{{ data.alt }}" aria-describedby="alt-text-description" {{ maybeReadOnly }} />
        </label>
        <p class="description" id="alt-text-description"><?php echo $alt_text_description; ?></p>
    <# } #>
    <?php if ( post_type_supports( 'attachment', 'title' ) ) : ?>
    <label class="setting" data-setting="title">
        <span class="name"><?php _e( 'Title' ); ?></span>
        <input type="text" value="{{ data.title }}" {{ maybeReadOnly }} />
    </label>
    <?php endif; ?>
    <# if ( 'audio' !== data.type ) { #>
    <label class="setting" data-setting="caption">
        <span class="name"><?php _e( 'Caption' ); ?></span>
        <textarea {{ maybeReadOnly }}>{{ data.caption }}</textarea>
    </label>
    <# } #>
    <label class="setting" data-setting="description">
        <span class="name"><?php _e( 'Description' ); ?></span>
        <textarea {{ maybeReadOnly }}>{{ data.description }}</textarea>
    </label>
    <div class="compat-meta">
        <# if ( data.compat && data.compat.meta ) { #>
            {{{ data.compat.meta }}}
        <# } #>
    </div>

    <# if ( 'audio' !== data.type ) { #>
    <label class="setting" data-setting="url">
        <span class="name"><?php _e( 'Copy Link' ); ?></span>
        <input type="text" value="{{ data.url }}" readonly />
    </label>
    <div class="details">
            <div class="filename">{{ data.filename }}</div>
            <div class="uploaded">{{ data.dateFormatted }}</div>

            <div class="file-size">{{ data.filesizeHumanReadable }}</div>
            <# if ( 'image' === data.type && ! data.uploading ) { #>
                <# if ( data.width && data.height ) { #>
                    <div class="dimensions">
                        <?php
                        /* translators: 1: a number of pixels wide, 2: a number of pixels tall. */
                        printf( __( '%1$s by %2$s pixels' ), '{{ data.width }}', '{{ data.height }}' );
                        ?>
                    </div>
                <# } #>

                <# if ( data.can.save && data.sizes ) { #>
                    <a class="edit-attachment" href="{{ data.editLink }}&amp;image-editor" target="_blank"><?php _e( 'Edit Image' ); ?></a>
                <# } #>
            <# } #>

            <# if ( data.fileLength && data.fileLengthHumanReadable ) { #>
                <div class="file-length"><?php _e( 'Length:' ); ?>
                    <span aria-hidden="true">{{ data.fileLength }}</span>
                    <span class="screen-reader-text">{{ data.fileLengthHumanReadable }}</span>
                </div>
            <# } #>

            <# if ( ! data.uploading && data.can.remove ) { #>
                <?php if ( MEDIA_TRASH ) : ?>
                <# if ( 'trash' === data.status ) { #>
                    <button type="button" class="button-link untrash-attachment"><?php _e( 'Restore from Trash' ); ?></button>
                <# } else { #>
                    <button type="button" class="button-link trash-attachment"><?php _e( 'Move to Trash' ); ?></button>
                <# } #>
                <?php else : ?>
                    <button type="button" class="button-link delete-attachment"><?php _e( 'Delete Permanently' ); ?></button>
                <?php endif; ?>
            <# } #>
        </div>
        <# } #>
    </div>
</script>

<script>
    (function( media ){
        const attDetailsOld = wp.media.view.Attachment.Details;
        console.log('attachment details!', attDetailsOld);
        const template = wp.template('attachment-details_jfm');
        wp.media.view.Attachment.Details = attDetailsOld.extend({
                template: template
        });
        
    })( wp.media );
</script>