import {mount} from "@vue/test-utils";
import {describe, expect, it} from "vitest";
import BackOfficeRow from "@/Components/Table/BackOfficeRow.vue";
import {nextTick} from "vue";

describe('Table BackOfficeRow', () => {
    const component = mount(BackOfficeRow, {
        props: {
            values: {id: '1', name: 'Crop 1', reports: 2, userId: 56},
            actions: [
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
            columns: [
                {column: 'id', name: 'ID', type: 'string'},
                {column: 'name', name: 'Nom', type: 'string'},
                {column: 'reports', name: 'Sign.', type: 'number'},
                {column: 'userId', name: 'Id Utilisateur', type: 'number', hidden: true},
            ]

        }
    });
    it('should render the component with right props', async () => {
        expect(component.props().values).toStrictEqual({id: '1', name: 'Crop 1', reports: 2, userId: 56});
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
        expect(component.props().columns).toStrictEqual([
                {column: 'id', name: 'ID', type: 'string'},
                {column: 'name', name: 'Nom', type: 'string'},
                {column: 'reports', name: 'Sign.', type: 'number'},
                {column: 'userId', name: 'Id Utilisateur', type: 'number', hidden: true}
            ]
        );
    });

    it('should emit show line event when the row is clicked', async () => {
        await component.trigger('click');
        expect(component.emitted()).toHaveProperty('show');
    });

    it('should display the right values in the row', async () => {
        expect(component.html()).toContain('Crop 1');
        expect(component.html()).toContain('2');
        expect(component.html()).toContain('1');
        expect(component.html()).not.toContain('56');
    });
    it('should emit custom action when the action is clicked', async () => {
        const actions = component.findAll('.action-row-button');
        await actions[0].trigger('click');
        await nextTick();
        expect(component.emitted()).toHaveProperty('action');
        const [args] = component.emitted().action;
        expect(args).toEqual(['seeCrop']);
    });
});
