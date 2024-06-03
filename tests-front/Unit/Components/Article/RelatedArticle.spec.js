import {mount} from '@vue/test-utils'
import {describe, expect, it} from "vitest";
import RelatedArticle from "@/Components/Article/RelatedArticle.vue";

describe('Article RelatedArticle', () => {
    const Component = mount(RelatedArticle, {
        props: {
            title: 'Article Title',
            author: 'Author 1',
            date: '2024-01-01 00:00:00',
            image: 'my-image.jpg',
            id: 1,
        }
    })
    it('should render the related article with right props', async () => {
        expect(Component.html()).toMatchSnapshot();
        expect(Component.props().title).toBe('Article Title');
        expect(Component.props().author).toBe('Author 1');
        expect(Component.props().date).toBe('2024-01-01 00:00:00');
        expect(Component.props().image).toBe('my-image.jpg');
        expect(Component.props().id).toBe(1);
    });
    it('should emit an event when the related article is clicked', async () => {
        await Component.trigger('click');
        expect(Component.emitted()).toHaveProperty('goToArticle');

        const [args] = Component.emitted().goToArticle;
        expect(args).toEqual([1]);
    });
});
