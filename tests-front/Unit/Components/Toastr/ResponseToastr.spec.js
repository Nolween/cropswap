import {mount} from "@vue/test-utils";
import {it, describe, expect} from "vitest";
import ResponseToastr from "@/Components/Toastr/ResponseToastr.vue";
import {nextTick} from "vue";

describe('Toastr ResponseToastr', () => {
    const component = mount(ResponseToastr);

    it('should render the component with right props', () => {
        expect(component.props().message).toBe('OK');
        expect(component.props().color).toBe('lime');
        expect(component.props().verticalPosition).toBe('right');
        expect(component.props().horizontalPosition).toBe('bottom');
        expect(component.props().duration).toBe(3000);
    })
    it('should close toastr when clicking on it', async () => {
        component.trigger('click');
        await nextTick();
        expect(component.vm.isOpen).toBe(false);
    });
    it('should close toastr after duration', async () => {
        await new Promise(resolve => setTimeout(resolve, 3200));
        expect(component.vm.isOpen).toBe(false);
    });
});
