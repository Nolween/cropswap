import {mount} from '@vue/test-utils'
import {describe, expect, it} from "vitest";
import ArticleCard from '@/Components/Article/ArticleCard.vue'

describe('Article ArticleCard', () => {
    it('should render the article card with right props', async () => {
        const Component = mount(ArticleCard, {
            props: {
                title: 'Article Title',
                content: 'Article Content',
                image: 'article-image.jpg',
                id: 1,
                isLoading: false,
            }
        })
        expect(Component.html()).toMatchSnapshot();
        expect(Component.props().title).toBe('Article Title');
        expect(Component.props().content).toBe('Article Content');
        expect(Component.props().image).toBe('article-image.jpg');
        expect(Component.props().id).toBe(1);
        expect(Component.props().isLoading).toBe(false);
    })

    it('should emit an event when the article card is clicked', async () => {
        const Component = mount(ArticleCard, {
            props: {
                title: 'Article Title',
                content: 'Article Content',
                image: 'article-image.jpg',
                id: 1,
                isLoading: false,
            }
        })
        await Component.trigger('click');
        expect(Component.emitted()).toHaveProperty('goToArticle');

        const [args] = Component.emitted().goToArticle;
        expect(args).toEqual([1]);
        expect(args[0]).toBe(1);
    });
})
