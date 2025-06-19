let routes= [];

import dashboard from "./vue-routes-dashboard";
import person from "./vue-routes-persons";
import product from "./vue-routes-products";

routes = routes.concat(dashboard);
routes = routes.concat(person);
routes = routes.concat(product);

export default routes;
