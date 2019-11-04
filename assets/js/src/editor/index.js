import registerBlocks from './blocks'

( function () {
  registerBlocks()
  wp.domReady(() => {
    wp.blocks.unregisterBlockType( 'core/audio' )
  })
}())
