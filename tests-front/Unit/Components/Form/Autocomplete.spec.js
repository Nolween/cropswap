import {mount} from "@vue/test-utils";
import {describe, expect, it} from "vitest";
import Autocomplete from "@/Components/Form/Autocomplete.vue";
import {nextTick} from "vue";

describe('Form Autocomplete', () => {
    const component = mount(Autocomplete, {
        props: {
            values: [{name: 'Product 1', id: 1}, {name: 'Product 2', id: 2}, {name: 'Product 3', id: 3}],
            selectedValues: [],
        }
    });
    it('should render the component with right props', async () => {
        expect(component.props().values).toEqual([{name: 'Product 1', id: 1}, {
            name: 'Product 2',
            id: 2
        }, {name: 'Product 3', id: 3}]);
        expect(component.props().selectedValues).toEqual([]);
        expect(component.props().placeholder).toBe('Rechercher une valeur');
        expect(component.props().isMultiple).toBe(false);
    });

    it('should open list when input value is clicked', async () => {
        // Update search input to get the first value
        const searchInput = component.find('.autocomplete-input');
        searchInput.trigger('click')
        // Waiting for the next tick to get the updated component
        await nextTick();
        expect(component.html()).toContain('autocomplete-list');
    });

    it('should filter values when typing in the input', async () => {
        // Update search input to get the first value
        const searchInput = component.find('.autocomplete-input');
        searchInput.setValue('Product 1')
        searchInput.trigger('click')
        // Waiting for the next tick to get the updated component
        await nextTick();
        expect(component.html()).toContain('Product 1');
        expect(component.vm.filteredValues).toEqual([{name: 'Product 1', id: 1}]);
    });

    it('should emit a value when clicking on it', async () => {
        const searchInput = component.find('.autocomplete-input');
        searchInput.trigger('click')
        await nextTick();
        // Find the first value and click on it
        const values = component.findAll('.autocomplete-value');
        await values[0].trigger('click');
        await nextTick();
        expect(component.emitted()).toHaveProperty('updateSelectedValues');
        const [args] = component.emitted().updateSelectedValues;
        expect(args).toEqual([[{name: 'Product 1', id: 1}]]);
    });

    it('should reset the search value by clicking on the cross', async () => {
        const searchInput = component.find('.autocomplete-input');
        searchInput.setValue('Product 1');
        await nextTick();
        expect(component.vm.search).toBe('Product 1');
        const cross = component.find('.autocomplete-cross');
        cross.trigger('click');
        await nextTick();
        expect(component.vm.search).toBe('');
    });

    it('should close the list when clicking outside', async () => {
        const searchInput = component.find('.autocomplete-input');
        searchInput.trigger('click')
        await nextTick();
        expect(component.html()).toContain('autocomplete-list');
        document.body.click();
        await nextTick();
        expect(component.html()).not.toContain('autocomplete-list');
    });

});
