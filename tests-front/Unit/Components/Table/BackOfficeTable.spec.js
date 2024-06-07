import {mount} from "@vue/test-utils";
import {describe, expect, it} from "vitest";
import BackOfficeTable from "@/Components/Table/BackOfficeTable.vue";

describe('Table BackOfficeTable', () => {
    const component = mount(BackOfficeTable, {
        props: {
            headers: [
                {column: 'id', name: 'ID', type: 'string'},
                {column: 'name', name: 'Nom', type: 'string'},
                {column: 'image', name: 'Image', type: 'image'},
                {column: 'user', name: 'Utilisateur', type: 'string'},
                {column: 'reports', name: 'Sign.', type: 'number'},
                {column: 'userId', name: 'Utilisateur', type: 'string', hidden: true},
            ],
            rows: [
                {
                    name: 'Crop 1',
                    id: '1',
                    image: '1.jpg',
                    user: 'User 1',
                    reports: 2,
                    userId: 56,
                },
                {
                    name: 'Crop 2',
                    id: '1',
                    image: '2.jpg',
                    user: 'User 2',
                    reports: 20,
                    userId: 3,
                },
            ],
            actions:[
                {
                    icon: 'Magnify',
                    color: 'blue',
                    method: 'seeCrop'
                },
                {
                    icon: 'Cancel',
                    color: 'red',
                    method: 'openBanModal',
                }
            ],
            perPage: 1,
        }
    });
    it('should render the component with default props', () => {
        expect(component.props().headers).toStrictEqual([
            {column: 'id', name: 'ID', type: 'string'},
            {column: 'name', name: 'Nom', type: 'string'},
            {column: 'image', name: 'Image', type: 'image'},
            {column: 'user', name: 'Utilisateur', type: 'string'},
            {column: 'reports', name: 'Sign.', type: 'number'},
            {column: 'userId', name: 'Utilisateur', type: 'string', hidden: true},
        ]);
        expect(component.props().rows).toStrictEqual([
            {
                name: 'Crop 1',
                id: '1',
                image: '1.jpg',
                user: 'User 1',
                reports: 2,
                userId: 56,
            },
            {
                name: 'Crop 2',
                id: '1',
                image: '2.jpg',
                user: 'User 2',
                reports: 20,
                userId: 3,
            },
        ]);
        expect(component.props().actions).toStrictEqual([
            {
                icon: 'Magnify',
                color: 'blue',
                method: 'seeCrop'
            },
            {
                icon: 'Cancel',
                color: 'red',
                method: 'openBanModal',
            }
        ]);
        expect(component.props().perPage).toBe(1);
    });
    it('should have a pagination', async () => {
        const pages = component.vm.pages;
        expect(pages).toBe(2);
    });
    it('should emit the show event when a row is clicked', async () => {
        const rows = component.findAll('.back-office-row');
        await rows[0].trigger('click');
        expect(component.emitted()).toHaveProperty('show');
    });
    it('should emit the action event when an action is clicked', async () => {
        const actions = component.findAll('.action-row-button');
        await actions[0].trigger('click');
        expect(component.emitted()).toHaveProperty('action');
        const [args] = component.emitted().action;
        expect(args[0].method).toEqual('seeCrop');
    });

    it('should update sortings when a header is clicked', async () => {
        const headers = component.findAll('.back-office-header');
        await headers[0].trigger('click');
        expect(component.vm.sorting).toEqual({column: 'id', asc: true});
        await headers[0].trigger('click');
        expect(component.vm.sorting).toEqual({column: 'id', asc: false});
    });

});
