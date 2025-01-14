import { Outlet, useMatches } from "react-router-dom";

import {XSidebar} from "@ximdex/xui-react/dist";
import Navbar from "../ui/Navbar";
import NavLink from "../ui/NavLink";
import ResourcesIcon from "../icons/Resources";
import GroupsIcon from "../icons/GroupsIcon";
import ServiceIcon from "../icons/ServiceIcon";

const menuItems = [
    { label: 'Resources', icon: () => <NavLink to={"resources"} ><ResourcesIcon/></NavLink> },
    { label: 'Groups', icon: () => <NavLink to={"groups"}><GroupsIcon/></NavLink> },
    { label: 'Services', icon: () => <NavLink to={"services"}><ServiceIcon/></NavLink> },
  ];

export default function NavbarSidebarLayout() {
    const match = useMatches();
    console.log(match);
    return (
        <>
            <div className="min-h-screen flex flex-col">
                <Navbar />
                <div className="flex flex-1">
                    <XSidebar menuItems={menuItems} className="pt-20"/>
                    <main className="flex-1 bg-white ">
                        <Outlet />
                    </main>
                </div>
            </div>
        </>
    );
}