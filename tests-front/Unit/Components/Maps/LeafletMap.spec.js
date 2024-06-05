import {mount} from '@vue/test-utils'
import {it, expect, describe} from 'vitest'
import LeafletMap from "@/Components/Maps/LeafletMap.vue";

describe('Maps LeafletMap', () => {
    const component = mount(LeafletMap, {
        props: {
            zoomLevel: 6,
            center: [46.605, 1.09],
            markers: [
                {
                    position: [46.605, 1.09],
                    icon: 'leaf-green',
                    id: 1,
                    description: 'Marker Description 1',
                    name: 'Crop 1'
                },
                {
                    position: [44.83, 2.85],
                    icon: 'leaf-green',
                    id: 2,
                    description: 'Marker Description 2',
                    name: 'Crop 2'
                },
            ]
        }

    });

    it('should render the component with default props', () => {
        expect(component.props().zoomLevel).toBe(6);
        expect(component.props().center).toStrictEqual([46.605, 1.09]);
        expect(component.props().markers).toStrictEqual([
                {
                    position: [46.605, 1.09],
                    icon: 'leaf-green',
                    id: 1,
                    description: 'Marker Description 1',
                    name: 'Crop 1'
                },
                {
                    position: [44.83, 2.85],
                    icon: 'leaf-green',
                    id: 2,
                    description: 'Marker Description 2',
                    name: 'Crop 2'
                },
            ]
        );
    });

});
