import {it, describe, expect} from "vitest"
import {mount} from '@vue/test-utils'
import ArticleCard from "@/Components/Cards/ArticleCard.vue";

describe('Cards ArticleCard', () => {
    const component = mount(ArticleCard,
        {
            props: {
                title: 'Article Title',
                content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum",
                image: 'image.jpg',
                date: '2024-01-01 12:00:00',
                tags: ['tag1', 'tag2'],
                user: 'User 1',
                id: 1,
                isLoading: false,
                contentLength: 50,
            }
        })

    it('should show component with right props', () => {
        expect(component.props().title).toBe('Article Title');
        expect(component.props().id).toBe(1);
        expect(component.props().date).toBe('2024-01-01 12:00:00')
        expect(component.props().contentLength).toBe(50);
        expect(component.props().user).toBe('User 1');
        expect(component.props().image).toBe('image.jpg');
        // Article Card should have a truncate content of 50 characters + ...
        expect(component.find('.article-card-content').text().length).toBe(53);
    });

    it('should emmit the goToTheArticle event', async() => {
        await component.trigger('click')
        expect(component.emitted()).toHaveProperty('goToArticle')

        const [args] = component.emitted().goToArticle;
        expect(args).toEqual([1]);

    })

    it('should emmit goToTag event', async() => {
        const tagButtons = component.findAll('.card-tag')
        await tagButtons[0].trigger('click')
        expect(component.emitted()).toHaveProperty('goToTag')


        const [args] = component.emitted().goToTag;
        expect(args).toEqual(['tag1']);

    })
})
