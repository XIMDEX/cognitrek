import { XNav, XNavProps } from "@ximdex/xui-react/dist";

function Navbar({logo, className, items, styles}: XNavProps ){
    return (
        <XNav
            logo={logo}
            className={className}
            items={items} 
            styles={styles}
        />
    )
}

export default Navbar