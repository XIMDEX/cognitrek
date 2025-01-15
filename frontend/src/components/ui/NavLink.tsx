import { NavLink } from "react-router-dom";

export default function XNavLink({to, children}) {
    return (
        <NavLink to={to} className={({ isActive }) => isActive ? '' : ''}>
            {children}
        </NavLink>
    )
}
