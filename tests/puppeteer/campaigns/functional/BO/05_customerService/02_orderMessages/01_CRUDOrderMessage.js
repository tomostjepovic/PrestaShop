require('module-alias/register');

const {expect} = require('chai');

// Import utils
const helper = require('@utils/helpers');
const loginCommon = require('@commonTests/loginBO');

// Import data
const OrderMessageFaker = require('@data/faker/orderMessage');

// Import pages
const LoginPage = require('@pages/BO/login');
const DashboardPage = require('@pages/BO/dashboard');
const OrderMessagesPage = require('@pages/BO/customerService/orderMessages');
const AddOrderMessagePage = require('@pages/BO/customerService/orderMessages/add');

// Import test context
const testContext = require('@utils/testContext');

const baseContext = 'functional_BO_customerService_orderMessages_CRUDOrderMessage';

let browser;
let browserContext;
let page;
let createOrderMessageData;
let editOrderMessageData;
let numberOfOrderMessages = 0;

// Init objects needed
const init = async function () {
  return {
    loginPage: new LoginPage(page),
    dashboardPage: new DashboardPage(page),
    orderMessagesPage: new OrderMessagesPage(page),
    addOrderMessagePage: new AddOrderMessagePage(page),
  };
};

/*
Create order message
Update order message
Delete order message
 */
describe('Create, update and delete order message', async () => {
  // before and after functions
  before(async function () {
    browser = await helper.createBrowser();
    browserContext = await helper.createBrowserContext(browser);
    page = await helper.newTab(browserContext);

    // Init page objects
    this.pageObjects = await init();

    // Init data
    createOrderMessageData = await (new OrderMessageFaker());
    editOrderMessageData = await (new OrderMessageFaker());
  });

  after(async () => {
    await helper.closeBrowser(browser);
  });

  // Login into BO and go to order messages page
  loginCommon.loginBO();

  it('should go to order messages page', async function () {
    await testContext.addContextItem(this, 'testIdentifier', 'goToOrderMessagesPage', baseContext);

    await this.pageObjects.dashboardPage.goToSubMenu(
      this.pageObjects.dashboardPage.customerServiceParentLink,
      this.pageObjects.dashboardPage.orderMessagesLink,
    );

    await this.pageObjects.orderMessagesPage.closeSfToolBar();

    const pageTitle = await this.pageObjects.orderMessagesPage.getPageTitle();
    await expect(pageTitle).to.contains(this.pageObjects.orderMessagesPage.pageTitle);
  });

  it('should reset all filters', async function () {
    await testContext.addContextItem(this, 'testIdentifier', 'resetFirst', baseContext);

    numberOfOrderMessages = await this.pageObjects.orderMessagesPage.resetAndGetNumberOfLines();
    await expect(numberOfOrderMessages).to.be.above(0);
  });

  // 1: Create order message
  describe('Create order message', async () => {
    it('should go to new order message page', async function () {
      await testContext.addContextItem(this, 'testIdentifier', 'goToNewOrderMessagePage', baseContext);

      await this.pageObjects.orderMessagesPage.goToAddNewOrderMessagePage();
      const pageTitle = await this.pageObjects.addOrderMessagePage.getPageTitle();
      await expect(pageTitle).to.contains(this.pageObjects.addOrderMessagePage.pageTitle);
    });

    it('should create order message', async function () {
      await testContext.addContextItem(this, 'testIdentifier', 'createOrderMessage', baseContext);

      const result = await this.pageObjects.addOrderMessagePage.addEditOrderMessage(createOrderMessageData);
      await expect(result).to.equal(this.pageObjects.orderMessagesPage.successfulCreationMessage);
    });

    it('should reset filters and check number of order messages', async function () {
      await testContext.addContextItem(this, 'testIdentifier', 'resetAfterCreate', baseContext);

      const numberOfOrderMessagesAfterReset = await this.pageObjects.orderMessagesPage.resetAndGetNumberOfLines();
      await expect(numberOfOrderMessagesAfterReset).to.be.equal(numberOfOrderMessages + 1);
    });
  });

  // 2: Update order message
  describe('Update order message', async () => {
    it('should filter by name of order message', async function () {
      await testContext.addContextItem(this, 'testIdentifier', 'filterToUpdate', baseContext);

      await this.pageObjects.orderMessagesPage.filterTable('name', createOrderMessageData.name);

      const numberOfOrderMessagesAfterFilter = await this.pageObjects.orderMessagesPage.getNumberOfElementInGrid();
      await expect(numberOfOrderMessagesAfterFilter).to.be.at.most(numberOfOrderMessages + 1);

      const textColumn = await this.pageObjects.orderMessagesPage.getTextColumnFromTable(1, 'name');
      await expect(textColumn).to.contains(createOrderMessageData.name);
    });

    it('should go to edit first order message page', async function () {
      await testContext.addContextItem(this, 'testIdentifier', 'goToEditPage', baseContext);

      await this.pageObjects.orderMessagesPage.gotoEditOrderMessage(1);
      const pageTitle = await this.pageObjects.addOrderMessagePage.getPageTitle();
      await expect(pageTitle).to.contains(this.pageObjects.addOrderMessagePage.pageTitleEdit);
    });

    it('should edit order message', async function () {
      await testContext.addContextItem(this, 'testIdentifier', 'updateOrderMessage', baseContext);

      const result = await this.pageObjects.addOrderMessagePage.addEditOrderMessage(editOrderMessageData);
      await expect(result).to.equal(this.pageObjects.orderMessagesPage.successfulUpdateMessage);
    });

    it('should reset filters and check number of order messages', async function () {
      await testContext.addContextItem(this, 'testIdentifier', 'resetAfterUpdate', baseContext);

      const numberOfOrderMessagesAfterReset = await this.pageObjects.orderMessagesPage.resetAndGetNumberOfLines();
      await expect(numberOfOrderMessagesAfterReset).to.be.equal(numberOfOrderMessages + 1);
    });
  });
  // 3: Delete order message
  describe('Delete order message', async () => {
    it('should filter by name of order message', async function () {
      await testContext.addContextItem(this, 'testIdentifier', 'filterToDelete', baseContext);

      await this.pageObjects.orderMessagesPage.filterTable('name', editOrderMessageData.name);

      const numberOfOrderMessagesAfterFilter = await this.pageObjects.orderMessagesPage.getNumberOfElementInGrid();
      await expect(numberOfOrderMessagesAfterFilter).to.be.at.most(numberOfOrderMessages + 1);

      const textColumn = await this.pageObjects.orderMessagesPage.getTextColumnFromTable(1, 'name');
      await expect(textColumn).to.contains(editOrderMessageData.name);
    });

    it('should delete order message', async function () {
      await testContext.addContextItem(this, 'testIdentifier', 'deleteOrderMessage', baseContext);

      // delete order message in first row
      const result = await this.pageObjects.orderMessagesPage.deleteOrderMessage(1);
      await expect(result).to.be.equal(this.pageObjects.orderMessagesPage.successfulDeleteMessage);
    });

    it('should reset filters and check number of order messages', async function () {
      await testContext.addContextItem(this, 'testIdentifier', 'resetAfterDelete', baseContext);

      const numberOfOrderMessagesAfterReset = await this.pageObjects.orderMessagesPage.resetAndGetNumberOfLines();
      await expect(numberOfOrderMessagesAfterReset).to.be.equal(numberOfOrderMessages);
    });
  });
});
