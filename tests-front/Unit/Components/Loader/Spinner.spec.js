import {mount}  from "@vue/test-utils";
import {describe, expect, it} from "vitest";
import Loader from "@/Components/Loader/Spinner.vue";

describe('Loader Spinner', () => {
   const component = mount(Loader);

   it('should render the component with default props', () => {
       expect(component.props().width).toBe('200px');
       expect(component.props().height).toBe('200px');
   });

   it('should render the spinner with the good size', () => {
       expect(component.find('.loader').attributes('style')).toBe('width: 200px; height: 200px;');
   });
});
