import { Outlet, redirect } from "react-router-dom";

import Navbar from "../ui/Navbar";
import NavLink from "../ui/NavLink";
import ResourcesIcon from "../icons/Resources";
import GroupsIcon from "../icons/GroupsIcon";
import ServiceIcon from "../icons/ServiceIcon";
import Avatar from "../ui/Avatar";
import Sidebar from "../ui/Sidebar";
import { logout } from "../../actions/AuthActions";
import HomeIcon from "../icons/HomeIcon";
import { useAuthStore } from "../../store/authStore";
import {  useMemo } from "react";
import { ROLES } from "../../config/constants";
import {StarIcon} from "../icons/StarIcon";

export default function NavbarSidebarLayout() {

    const {user} = useAuthStore(); 
    
    const handleLogout = () => {
        logout();
        redirect('/login');
    }

    const items = useMemo(() => {
        const data = [
            { label: 'Home', icon: () => <NavLink to={"/"} ><HomeIcon/></NavLink> },
            { label: 'Resources', icon: () => <NavLink to={"resources"} ><ResourcesIcon/></NavLink> },
            { label: 'Groups', icon: () => <NavLink to={"groups"}><GroupsIcon/></NavLink> },
        ]
        if (user?.role == ROLES.ADMIN || user?.role == ROLES.SUPERADMIN) {
            data.push({ label: 'Feedback', icon: () => <NavLink to={"resources-feedback"}><StarIcon className=""/></NavLink> })
            data.push({ label: 'Traces', icon: () => <NavLink to={"traces"}><ServiceIcon/></NavLink> })
        }
        return data;
    }, [user]);

    return (
        <div className="h-full w-full flex flex-col">
            <Navbar 
                logo="logotipo_ximdex-white-small.png" 
                className="border-b text-white px-4 py-3 flex justify-between items-center h-[100px] bg-primary"
                items={[
                    <Avatar
                        size="md"
                        image={user?.image ?? ''}  
                        username={user?.name ?? ''}
                        email={user?.email ?? ''}
                        items={[
                            // <button className="block w-full text-left">Profile</button>,
                            <button onClick={handleLogout} className="block w-full text-left">Logout</button>,
                        ]}
                    />
                ]}
            />
            <div className="flex overflow-hidden flex-grow">
                <Sidebar items={items} />
                <main className="flex-1 bg-white ">
                    <Outlet />
                </main>
            </div>
        </div>
    );
}

