using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace DataModel
{
    public class RoleRepository
    {
        private CSE502Entities entities = new CSE502Entities();


        public bool AddRole(Role role)
        {
            entities.Roles.Add(role);
            return entities.SaveChanges() > 0;
        }

        public List<Role> SelectAll()
        {
            return entities.Roles.ToList();
        }

        public Role SelectRoleById(int id)
        {
            //return entities.Roles.Where(r => r.Id == id).FirstOrDefault();


            //foreach (Role r in entities.Roles)
            //{
            //    if (r.Id == id)
            //    {
            //        return r;
            //    }
            //}
            //return new Role();

            var role = (from r in entities.Roles
                        where r.Id == id
                        select r).FirstOrDefault();
            return role;
        }

        public bool DeleteRole(int id)
        {
            var role = (from r in entities.Roles
                        where r.Id == id
                        select r).FirstOrDefault();

            entities.Roles.Remove(role);
            return entities.SaveChanges() > 0;
        }

        public bool UpdateRole(Role role)
        {
            entities.Roles.Add(role);
            entities.Entry(role).State = System.Data.Entity.EntityState.Modified;
            return entities.SaveChanges() > 0;

        }

    }
}
