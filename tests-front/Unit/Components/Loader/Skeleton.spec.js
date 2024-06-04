import {mount} from "@vue/test-utils";
import {describe, expect, it} from "vitest";
import Skeleton from "@/Components/Loader/Skeleton.vue";

describe('Loader Skeleton', () => {
    const component = mount(Skeleton);

    it('should render the component with default props', () => {
        expect(component.props().hasImage).toBe(true);
        expect(component.props().minRows).toBe(2);
        expect(component.props().maxRows).toBe(4);
        expect(component.props().disposition).toBe('horizontal');
    });

    it('should render image skeleton when hasImage is true', async () => {
        expect(component.find('.animate-image').exists()).toBe(true);
    });

    it('should render text skeleton when hasImage is false', async () => {
        await component.setProps({hasImage: false});
        expect(component.find('.animate-image').exists()).toBe(false);
    });

    it('should render the right number of rows', async () => {
        expect(component.findAll('.animate-row').length).toBeGreaterThanOrEqual(2);
        expect(component.findAll('.animate-row').length).toBeLessThanOrEqual(4);
    });

});
