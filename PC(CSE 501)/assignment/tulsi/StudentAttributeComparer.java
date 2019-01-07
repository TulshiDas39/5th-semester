package assignment2;

import javax.print.attribute.standard.RequestingUserName;

public class StudentAttributeComparer implements Icomparer {
	private Icomparer c;
	private int cmp;

	public StudentAttributeComparer(Icomparer c, int cmp) {
		this.c = c;
		this.cmp = cmp;
	}

	public StudentAttributeComparer(int cmp) {
		c = new Nullcomparer();
		this.cmp = cmp;
	}

	public int compare(Student x, Student y) {
		// TODO Auto-generated method stub
		if ((x.convertstring(cmp).compareTo(y.convertstring(cmp))) > 0)
		{
			//System.out.println("joy  "+(x.convertstring(cmp))+" "+(y.convertstring(cmp)));
			return 1;
		}

		if ((x.convertstring(cmp).compareTo(y.convertstring(cmp))) < 0)
		{
			//System.out.println("maloy  "+(x.convertstring(cmp))+" "+(y.convertstring(cmp)));
			return -1;
		}
		return c.compare(x, y);
	}

}
