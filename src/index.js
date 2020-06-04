import { registerBlockType } from '@wordpress/blocks';
import Edit from './Edit';

console.log ("aaa");

registerBlockType( 'proca/action', {
    title: 'Proca campaign',
    icon: 'megaphone',
    category: 'widgets',
    edit: () => <Edit/>,
    save: () => <div>[proca action=climateandjobs-form.eu]</div>,
} );
