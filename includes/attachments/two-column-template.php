<?php // Template for the Attachment Details two columns layout. ?>

<script type="text/html" id="tmpl-attachment-details-two-column_jfm">
    <div class="attachment-media-view {{ data.orientation }}">
        <h2 class="screen-reader-text"><?php _e( 'Attachment Preview' ); ?></h2>
        <div class="thumbnail thumbnail-{{ data.type }}">
            <# if ( data.uploading ) { #>
                <div class="media-progress-bar"><div></div></div>
            <# } else if ( data.sizes && data.sizes.large ) { #>
                <img class="details-image" src="{{ data.sizes.large.url }}" draggable="false" alt="" />
            <# } else if ( data.sizes && data.sizes.full ) { #>
                <img class="details-image" src="{{ data.sizes.full.url }}" draggable="false" alt="" />
            <# } else if ( -1 === jQuery.inArray( data.type, [ 'audio', 'video' ] ) ) { #>
                <img class="details-image icon" src="{{ data.icon }}" draggable="false" alt="" />
            <# } #>

            <# if ( 'audio' === data.type ) { #>
            <div class="wp-media-wrapper">
                <h3>AUDIO!!!!</h3>
                <audio style="visibility: hidden" controls class="wp-audio-shortcode" width="100%" preload="none">
                    <source type="{{ data.mime }}" src="{{ data.url }}"/>
                </audio>
            </div>
            <# } else if ( 'video' === data.type ) {
                var w_rule = '';
                if ( data.width ) {
                    w_rule = 'width: ' + data.width + 'px;';
                } else if ( wp.media.view.settings.contentWidth ) {
                    w_rule = 'width: ' + wp.media.view.settings.contentWidth + 'px;';
                }
            #>
            <div style="{{ w_rule }}" class="wp-media-wrapper wp-video">
                <video controls="controls" class="wp-video-shortcode" preload="metadata"
                    <# if ( data.width ) { #>width="{{ data.width }}"<# } #>
                    <# if ( data.height ) { #>height="{{ data.height }}"<# } #>
                    <# if ( data.image && data.image.src !== data.icon ) { #>poster="{{ data.image.src }}"<# } #>>
                    <source type="{{ data.mime }}" src="{{ data.url }}"/>
                </video>
            </div>
            <# } #>

            <div class="attachment-actions">
                <# if ( 'image' === data.type && ! data.uploading && data.sizes && data.can.save ) { #>
                <button type="button" class="button edit-attachment"><?php _e( 'Edit Image' ); ?></button>
                <# } else if ( 'pdf' === data.subtype && data.sizes ) { #>
                <p><?php _e( 'Document Preview' ); ?></p>
                <# } #>
            </div>
        </div>
    </div>
    <div class="attachment-info">
        <span class="settings-save-status" role="status">
            <span class="spinner"></span>
            <span class="saved"><?php esc_html_e( 'Saved.' ); ?></span>
        </span>

        <div class="settings">
            <# var maybeReadOnly = data.can.save || data.allowLocalEdits ? '' : 'readonly'; #>
            <# if ( 'image' === data.type ) { #>
                <span class="setting has-description" data-setting="alt">
                    <label for="attachment-details-two-column-alt-text" class="name"><?php _e( 'Alternative Text' ); ?></label>
                    <input type="text" id="attachment-details-two-column-alt-text" value="{{ data.alt }}" aria-describedby="alt-text-description" {{ maybeReadOnly }} />
                </span>
                <p class="description" id="alt-text-description"><?php echo $alt_text_description; ?></p>
            <# } #>
            <?php if ( post_type_supports( 'attachment', 'title' ) ) : ?>
            <span class="setting" data-setting="title">
                <label for="attachment-details-two-column-title" class="name"><?php _e( 'Title' ); ?></label>
                <input type="text" id="attachment-details-two-column-title" value="{{ data.title }}" {{ maybeReadOnly }} />
            </span>
            <?php endif; ?>
            <span class="setting" data-setting="description">
                <label for="attachment-details-two-column-description" class="name"><?php _e( 'Description' ); ?></label>
                <textarea id="attachment-details-two-column-description" {{ maybeReadOnly }}>{{ data.description }}</textarea>
            </span>
            <div class="attachment-compat"></div>
            <# if ( 'audio' !== data.type ) { #>
            <span class="setting" data-setting="caption">
                <label for="attachment-details-two-column-caption" class="name"><?php _e( 'Caption' ); ?></label>
                <textarea id="attachment-details-two-column-caption" {{ maybeReadOnly }}>{{ data.caption }}</textarea>
            </span>
            <# } #>
            <span class="setting">
                <span class="name"><?php _e( 'Uploaded By' ); ?></span>
                <span class="value">{{ data.authorName }}</span>
            </span>
            <# if ( data.uploadedToTitle ) { #>
                <span class="setting">
                    <span class="name"><?php _e( 'Uploaded To' ); ?></span>
                    <# if ( data.uploadedToLink ) { #>
                        <span class="value"><a href="{{ data.uploadedToLink }}">{{ data.uploadedToTitle }}</a></span>
                    <# } else { #>
                        <span class="value">{{ data.uploadedToTitle }}</span>
                    <# } #>
                </span>
            <# } #>
            <span class="setting" data-setting="url">
                <label for="attachment-details-two-column-copy-link" class="name"><?php _e( 'Copy Link' ); ?></label>
                <input type="text" id="attachment-details-two-column-copy-link" value="{{ data.url }}" readonly />
            </span>
        </div>

        <div class="details">
            <h2 class="screen-reader-text"><?php _e( 'Details' ); ?></h2>
            <div class="filename"><strong><?php _e( 'File name:' ); ?></strong> {{ data.filename }}</div>
            <div class="filename"><strong><?php _e( 'File type:' ); ?></strong> {{ data.mime }}</div>
            <div class="uploaded"><strong><?php _e( 'Uploaded on:' ); ?></strong> {{ data.dateFormatted }}</div>

            <div class="file-size"><strong><?php _e( 'File size:' ); ?></strong> {{ data.filesizeHumanReadable }}</div>
            <# if ( 'image' === data.type && ! data.uploading ) { #>
                <# if ( data.width && data.height ) { #>
                    <div class="dimensions"><strong><?php _e( 'Dimensions:' ); ?></strong>
                        <?php
                        /* translators: 1: A number of pixels wide, 2: A number of pixels tall. */
                        printf( __( '%1$s by %2$s pixels' ), '{{ data.width }}', '{{ data.height }}' );
                        ?>
                    </div>
                <# } #>
            <# } #>

            <# if ( data.fileLength && data.fileLengthHumanReadable ) { #>
                <div class="file-length"><strong><?php _e( 'Length:' ); ?></strong>
                    <span aria-hidden="true">{{ data.fileLength }}</span>
                    <span class="screen-reader-text">{{ data.fileLengthHumanReadable }}</span>
                </div>
            <# } #>

            <# if ( 'audio' === data.type && data.meta.bitrate ) { #>
                <div class="bitrate">
                    <strong><?php _e( 'Bitrate:' ); ?></strong> {{ Math.round( data.meta.bitrate / 1000 ) }}kb/s
                    <# if ( data.meta.bitrate_mode ) { #>
                    {{ ' ' + data.meta.bitrate_mode.toUpperCase() }}
                    <# } #>
                </div>
            <# } #>

            <div class="compat-meta">
                <# if ( data.compat && data.compat.meta ) { #>
                    {{{ data.compat.meta }}}
                <# } #>
            </div>
        </div>

        <div class="actions">
            <a class="view-attachment" href="{{ data.link }}"><?php _e( 'View attachment page' ); ?></a>
            <# if ( data.can.save ) { #> |
                <a href="{{ data.editLink }}"><?php _e( 'Edit more details' ); ?></a>
            <# } #>
            <# if ( ! data.uploading && data.can.remove ) { #> |
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
    </div>
</script>

<script>
    (function( media ){
        const attDetailsOld = wp.media.view.Attachment.Details.TwoColumn;
        const template = wp.template('attachment-details-two-column_jfm');
        //const template = wp.template( $("#tmpl-attachment-details-two-column_jfm").html() );	
        console.log('template', template);
        wp.media.view.Attachment.Details.TwoColumn = attDetailsOld.extend({
                template: template
        });
        
    })( wp.media );
</script>