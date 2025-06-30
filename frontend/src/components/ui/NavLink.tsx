import { NavLink } from "react-router-dom";

import { ReactNode } from "react";

interface XNavLinkProps {
    to: string;
    children: ReactNode;
}

export default function XNavLink({ to, children }: XNavLinkProps) {
    return (
        <NavLink to={to} className={({ isActive }) => isActive ? '' : ''}>
            {children}
        </NavLink>
    )
}
