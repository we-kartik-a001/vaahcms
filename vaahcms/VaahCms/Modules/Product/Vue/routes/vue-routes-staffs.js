let routes= [];
let routes_list= [];

import List from '../pages/staffs/List.vue'
import Form from '../pages/staffs/Form.vue'
import Item from '../pages/staffs/Item.vue'
import Filters from '../pages/staffs/Filters.vue'

routes_list = {

    path: '/staffs',
    name: 'staffs.index',
    component: List,
    props: true,
    children:[
        {
            path: 'form/:id?',
            name: 'staffs.form',
            component: Form,
            props: true,
        },
        {
            path: 'view/:id?',
            name: 'staffs.view',
            component: Item,
            props: true,
        },
        {
            path: 'filters',
            name: 'staffs.filters',
            component: Filters,
            props: true,
        },

    ]
};

routes.push(routes_list);

export default routes;

