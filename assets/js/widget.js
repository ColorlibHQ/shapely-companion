jQuery( document ).ready(function() {// jscs:ignore validateLineBreaks

    /* Clonning of Logo Client Widgets */
    jQuery( document ).on( 'widget-added', function() {
        shapelySort();
    });
    jQuery( document ).on( 'widget-updated', function() {
        shapelySort();
    });

    shapelySort();

    /* Client widget sorting and cloning*/
    /* Font awsome selector */
    jQuery( 'select.shapely-icon' ).change(function() {
        jQuery( this ).siblings( 'span' ).removeClass().addClass( 'fa ' + jQuery( this ).val() );
    });

    /*
     * Function for sorting
     */
    function shapelySort() {
        jQuery( '.client-sortable' ).sortable({
            handle: '.logo_heading'
        })
            .bind( 'sortupdate', function() {
                var index = 0, img;
                var attrname = jQuery( this ).find( 'input:first' ).attr( 'name' );
                var attrbase = attrname.substring( 0, attrname.indexOf( '][' ) + 1 );
                var attrid = jQuery( this ).find( 'input:first' ).attr( 'id' );
                var attrbaseid = attrid.substring( 0, attrid.indexOf( '-client_logo' ) + 13 );

                jQuery( this ).find( 'li' ).each(function() {
                    jQuery( this ).find( '.count' ).html( index + 1 );
                    jQuery( this ).find( '.image-id' ).attr( 'id', attrbaseid + index ).attr( 'name', attrbase + '[client_logo][img]' + '[' + index + ']' );
                    jQuery( this ).find( '.shapely-media-control' ).attr( 'data-delegate-container', attrbaseid + index );
                    jQuery( this ).find( 'img' ).attr( 'id', 'link-' + index ).attr( 'name', attrbase + '[client_logo][link]' + '[' + index + ']' ).trigger( 'change' );
                    index++;
                });
            });

        /* Cloning */
        jQuery( '.clone-wrapper' ).cloneya().on( 'after_append.cloneya after_delete.cloneya', function( toClone, newClone ) {
            var img = jQuery( newClone ).next( 'li' ).find( 'img' );
            jQuery( '.client-sortable' ).trigger( 'sortupdate' );
            img.attr( 'src', img.attr( 'data-default' ) );
        });

    }

});
