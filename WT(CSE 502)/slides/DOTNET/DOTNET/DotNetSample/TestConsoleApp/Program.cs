using DataModel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TestConsoleApp
{
    class Program
    {
        static void Main(string[] args)
        {
            RoleRepository roleRepository = new RoleRepository();

            Role role = new Role() { RoleName = "User", RoleDescription = "User Role" };

            if (roleRepository.AddRole(role))
            {
                Console.WriteLine("Success!!!");
            }
            else
            {
                Console.WriteLine("Failed!!!");
            }


        }
    }
}
