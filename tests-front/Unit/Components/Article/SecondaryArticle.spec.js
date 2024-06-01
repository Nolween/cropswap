import {mount} from '@vue/test-utils'
import {describe, expect, it} from "vitest";
import SecondaryArticle from "@/Components/Article/SecondaryArticle.vue";

describe('Article SecondaryArticle', () => {

    const Component = mount(SecondaryArticle, {
        props: {
            title: 'Article Title',
            content: 'Article Content',
            image: 'article-image.jpg',
            id: 1,
            isLoading: false,
        }
    })
    it('should render the secondary article with right props', async () => {
        expect(Component.html()).toMatchSnapshot();
        expect(Component.props().title).toBe('Article Title');
        expect(Component.props().content).toBe('Article Content');
        expect(Component.props().image).toBe('article-image.jpg');
        expect(Component.props().id).toBe(1);
        expect(Component.props().isLoading).toBe(false);
    })

    it('should emit an event when the secondary article is clicked', async () => {
        await Component.trigger('click');
        expect(Component.emitted()).toHaveProperty('goToArticle');

        const [args] = Component.emitted().goToArticle;
        expect(args).toEqual([1]);
        expect(args[0]).toBe(1);
    });
    it('should show skeleton when loading', async () => {
        await Component.setProps({isLoading: true});
        expect(Component.findComponent({name: 'Skeleton'}).exists()).toBe(true);

    });
});
