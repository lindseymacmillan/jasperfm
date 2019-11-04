import registerDynamicBlock from './dynamic-block'
import registerAudioBlock from './audio-block';

const registerBlocks = () => {
    registerAudioBlock();
    registerDynamicBlock();
}
export default registerBlocks;