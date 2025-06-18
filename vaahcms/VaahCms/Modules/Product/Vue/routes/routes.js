let routes= [];

import dashboard from "./vue-routes-dashboard";
import brand from "./vue-routes-brands";
import item from "./vue-routes-items";
import staff from "./vue-routes-staffs";
import employee from "./vue-routes-employees";


routes = routes.concat(dashboard);
routes = routes.concat(brand);
routes = routes.concat(item);
routes = routes.concat(staff);
routes = routes.concat(employee);


export default routes;
// 