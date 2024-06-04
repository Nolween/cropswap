import {mount} from '@vue/test-utils'
import {describe, expect, it} from "vitest";
import CompleteEditor from "@/Components/Editors/CompleteEditor.vue";

describe('Editors CompleteEditor', () => {
    const component = mount(CompleteEditor, {
        props: {
            modelValue: 'Model Value',
        }
    });
    it('should render thçe editor with right props', async () => {
        expect(component.props().modelValue).toBe('Model Value');
    });

});
