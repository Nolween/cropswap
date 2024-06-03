import {mount} from '@vue/test-utils'
import {it, expect, describe} from 'vitest'
import SimpleCard from "@/Components/Cards/SimpleCard.vue";
import BarleyIcon from "../../../../node_modules/vue-material-design-icons/Barley.vue";

describe('Cards SimpleCard', () => {
    const component = mount(SimpleCard, {
        props: {
            title: 'Card Title',
            description: 'Card Description',
            icon: 'Barley',
        }
    })

    it('should render component with right props', () => {
        expect(component.props().description).toBe('Card Description');
        expect(component.props().title).toBe('Card Title');
        expect(component.props().icon).toBe('Barley');
        expect(component.props().iconColor).toBe('black');
    })

    it('should mount BarleyIcon after onMounted', async () => {
        await component.vm.$nextTick(); // Wait for next DOM update
        const barleyIcon = component.findComponent(BarleyIcon);
        expect(barleyIcon.exists()).toBe(true);
    })
})
