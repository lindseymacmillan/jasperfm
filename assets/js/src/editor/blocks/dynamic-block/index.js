const blocks = wp.blocks
const element = wp.element
const data = wp.data

const registerDynamicBlock = () => {
  const el = element.createElement,
  registerBlockType = blocks.registerBlockType,
  withSelect = data.withSelect;

  registerBlockType( 'gutenberg-examples/example-05-dynamic', {
      title: 'Example: last post',
      icon: 'megaphone',
      category: 'widgets',

      edit: withSelect( function( select ) {
          return {
              posts: select( 'core' ).getEntityRecords( 'postType', 'post' )
          };
      } )( function( props ) {

          if ( ! props.posts ) {
              return "Loading...";
          }

          if ( props.posts.length === 0 ) {
              return "No posts";
          }
          var className = props.className;
          var post = props.posts[ 0 ];

          return el(
              'a',
              { className: className, href: post.link },
              post.title.rendered
          );
      } ),

      save: () => {
        return null
      }
  } );
}
export default registerDynamicBlock
