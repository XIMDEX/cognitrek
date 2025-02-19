import { Outlet, redirect } from "react-router-dom";

import Navbar from "../ui/Navbar";
import NavLink from "../ui/NavLink";
import ResourcesIcon from "../icons/Resources";
import GroupsIcon from "../icons/GroupsIcon";
import ServiceIcon from "../icons/ServiceIcon";
import Avatar from "../ui/Avatar";
import Sidebar from "../ui/Sidebar";
import { logout } from "../../actions/AuthActions";

export default function NavbarSidebarLayout() {
    
    const handleLogout = () => {
        logout();
        redirect('/login');
    }


    return (
        <div className="h-full w-full flex flex-col">
            <Navbar 
                logo="logotipo_ximdex-white-small.png" 
                className="border-b text-white px-4 py-3 flex justify-between items-center h-[100px] bg-primary"
                items={[
                    <Avatar
                        size="md"
                        image="https://as2.ftcdn.net/v2/jpg/02/14/74/61/1000_F_214746128_31JkeaP6rU0NzzzdFC4khGkmqc8noe6h.jpg"  
                        username="Fran Enriquez" 
                        email="fenriqez@ximdex.com" 
                        items={[
                            <button className="block w-full text-left">Profile</button>,
                            <button onClick={handleLogout} className="block w-full text-left">Logout</button>,
                        ]}
                    />
                ]}
            />
            <div className="flex overflow-hidden flex-grow">
                <Sidebar 
                    items={[
                        { label: 'Resources', icon: () => <NavLink to={"resources"} ><ResourcesIcon/></NavLink> },
                        { label: 'Groups', icon: () => <NavLink to={"groups"}><GroupsIcon/></NavLink> },
                        { label: 'Services', icon: () => <NavLink to={"services"}><ServiceIcon/></NavLink> }
                    ]} 
                />
                <main className="flex-1 bg-white ">
                    <Outlet />
                </main>
            </div>
        </div>
    );
}